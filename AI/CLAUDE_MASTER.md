# CLAUDE MASTER

> The Claude-specific entry point. [MASTER.md](MASTER.md) is the project brief and
> [AGENT_PROTOCOL.md](AGENT_PROTOCOL.md) is the procedure — both apply here unchanged. This file covers
> only what is specific to running **Claude Code** against this repository: which tools work, which
> commands are the right ones, and the tool-level mistakes that have already happened.
>
> The Gemini equivalent is [GEMINI_MASTER.md](GEMINI_MASTER.md). Keep the two consistent; when a fact
> about the project changes, it belongs in `MASTER.md`, not in either of these.

---

## 1. Read order for a cold start

1. `AGENTS.md` at the git root — the owner's own instructions. **They win over anything in `AI/`.**
2. [MASTER.md](MASTER.md) — what the project is, and the ten rules.
3. [AGENT_HANDOFF.md](AGENT_HANDOFF.md) → [TASK_STATE.md](TASK_STATE.md) — where the work stands.
4. The relevant brief in [agents/](agents), then the module `README.md` if one exists.

Do not read the whole tree. It is 27 documents; four of them plus one brief is the working set.

## 2. Working directory vs git root — the one thing to get right first

```
C:\Users\sai\Desktop\WhatsApp CRM        <- git root. AGENTS.md and AI/ live here
C:\Users\sai\Desktop\WhatsApp CRM\DT Brand  <- the live tree, and the usual cwd
```

`AI/` is **one level above** the working directory. A relative path that "should" work often does not, and
the folder name contains a space, so every path needs quoting in `bash`:

```bash
git -C "/c/Users/sai/Desktop/WhatsApp CRM" status --short
```

`DT Brand/`'s *contents* become `/public_html/` on live. That is why `/DT%20Brand/` in a URL is always a
bug — 16 of them survive in 6 admin JS files ([KNOWN_ISSUES.md](KNOWN_ISSUES.md) KI-10).

## 3. Tool choices that matter here

| Task | Use | Not |
| :--- | :--- | :--- |
| Read a file | `Read` | `cat`, `head` |
| Edit | `Edit` with a unique anchor | `sed`, `awk`, `echo >>` |
| Find files | `Glob` | `find`, `ls -R` |
| Search content | `Grep` with `glob:` / `path:` scoping | `grep` in `Bash` |
| PHP syntax | `Bash` — there is no lint tool | — |

**Scope every `Grep`.** An unscoped search returns two hits for everything, because GEN-B is a complete
second copy of the same product. Pass `path: "DT Brand"`, and match **full** asset paths — a basename
match produced three wrong conclusions in this repo ([DECISIONS.md](DECISIONS.md) D-9).

## 4. The commands, verbatim

```bash
/c/xampp/php/php.exe -l "DT Brand/src/OrderManager.php"
```

```bash
node --check --input-type=commonjs < "DT Brand/admin/resellers/assets/js/reseller.js"
```

Whole-tree PHP lint, from the git root:

```bash
find "DT Brand" -name '*.php' -print0 | xargs -0 -P 8 -n 1 /c/xampp/php/php.exe -l 2>&1 | grep -v "No syntax errors"
```

PHP 8.2 is at `/c/xampp/php/php.exe` and is **not on `PATH`** — `php -l` alone fails. **There is no MySQL
in this environment**, so nothing DB-dependent can be executed; say that rather than implying a check
passed (KI-22).

**Keep script output ASCII-only.** The Windows console is cp1252 and a helper script that prints an em
dash or a ₹ dies on encoding, which then reads as a broken script rather than a broken console.

## 5. Writing long documents

`Write` and `Edit` have content-size limits. The pattern that works, used for every long file in this
tree: `Write` the first chunk ending in a unique placeholder such as `<!-- CHUNK-2 -->`, then `Edit` that
placeholder into the next chunk plus a fresh placeholder, and omit the placeholder on the final chunk.
Chunks of ~40-50 lines are comfortable.

Two rules learned the hard way: use a placeholder that appears **exactly once**, and after the final chunk
`Read` the tail of the file to confirm no placeholder survived and nothing was duplicated.

## 6. Subagents, and why the bootstrap was single-threaded

Twelve specialist briefs exist in [agents/](agents) and they are written to be delegated to. **In the
session that created them, all ten spawned subagents died on API 403 quota errors**, so the entire audit
was done in the main thread. If delegation fails the same way, do not retry ten times — work
single-threaded and say so in the report.

When delegation *does* work, give a subagent the brief plus the specific files, and require it to return
`file:line` evidence. Do not let a subagent's summary into a document unverified: this audit corrected
eight inherited claims that were confidently wrong ([CHANGELOG.md](CHANGELOG.md) §5).

Only spawn a subagent when the user has asked for it, or the work genuinely fans out across many
independent files.

## 7. Persistent memory

Notes that must survive a session live in the user's memory directory, one fact per file with
frontmatter, indexed by `MEMORY.md`. Three exist and are worth knowing before you start:

| Memory | Fact |
| :--- | :--- |
| `live-schema-is-arniya-only` | `arniya_master_production.sql` is the only schema that runs — **18 tables**; the `2026_08_25` migration never executes and its columns are phantom |
| `dtbrand-static-verification-only` | PHP 8.2 at `/c/xampp/php/php.exe`; no MySQL; ASCII-only output; **the owner deploys, not the agent** |
| `dtbrand-audit-phase-plan` | which phases are done, what is open, and what is blocked on the owner |

Keep them short and factual. Anything that belongs to the repository — file structure, past fixes, git
history — belongs in this `AI/` tree instead, where the next agent will actually look for it.

## 8. Conversation-level habits that fit this project

- **The context window will compact.** Write findings down *as you get them*, in the document that owns
  them. A measurement that exists only in the conversation is a measurement that will be lost, and then
  re-derived incorrectly.
- **Verify before repeating an inherited claim.** The single most useful catch of the audit was grepping
  a carried-forward to-do ("the WhatsApp number differs in three places") and finding **all 47 raw
  occurrences already correct** — the task had been completed in a previous session. Recording it as a
  live defect would have sent the next agent to edit working code.
- **One command, one claim.** Every count in this tree should be reproducible by a command you could paste
  back. If you cannot produce that command, mark the claim unverified.
- **Do not modify application code during a documentation phase.** The current phase's invariant is
  "documentation only", and stating that it held is part of the deliverable.
- **End with the report.** TASK · ROOT CAUSE · CHANGES · TESTS · RESULT · RISKS · NEXT, and `NEXT` names
  the files the owner must upload (D-8).

## 9. Absolute limits

No `git reset --hard`, `push --force`, `clean -f`, `branch -D`, `rebase`, or history rewrite without the
owner's explicit permission, every time. No `DROP` / `TRUNCATE` / unconditioned `DELETE`, ever. No file
deletion without a classification and an instruction (D-9). No credential value in any output — file, line
and variable name only (SEC-1). No deployment: **the owner deploys.**


