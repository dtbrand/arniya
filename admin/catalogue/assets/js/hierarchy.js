/**
 * hierarchy.js — Category Tree Operations & Native Direct Mouse Drag & Drop
 * DT Brand's & Jai Hanuman Tex
 */
window.DT_HIERARCHY = {
    draggedNode: null,

    toggleNode: function(btn, childrenId) {
        const children = document.getElementById(childrenId);
        if (!children) return;
        const isHidden = children.style.display === 'none';
        children.style.display = isHidden ? 'block' : 'none';
        btn.textContent = isHidden ? '−' : '+';
    },

    expandAll: function() {
        document.querySelectorAll('.dt-tree-children').forEach(el => el.style.display = 'block');
        document.querySelectorAll('.dt-tree-toggle').forEach(btn => btn.textContent = '−');
        if (window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('Expanded all category levels');
    },

    collapseAll: function() {
        document.querySelectorAll('.dt-tree-children').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.dt-tree-toggle').forEach(btn => btn.textContent = '+');
        if (window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('Collapsed all category levels');
    },

    moveUp: function(nodeId) {
        const node = document.getElementById(nodeId);
        if (node && node.previousElementSibling) {
            node.parentNode.insertBefore(node, node.previousElementSibling);
            if (window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('Category moved up');
        }
    },

    moveDown: function(nodeId) {
        const node = document.getElementById(nodeId);
        if (node && node.nextElementSibling) {
            node.parentNode.insertBefore(node.nextElementSibling, node);
            if (window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('Category moved down');
        }
    },

    // ════ Native Direct Mouse Drag & Drop ════
    initDragAndDrop: function() {
        const nodes = document.querySelectorAll('.dt-tree-node');
        
        nodes.forEach(node => {
            node.setAttribute('draggable', 'true');

            // Drag Start
            node.addEventListener('dragstart', (e) => {
                e.stopPropagation();
                window.DT_HIERARCHY.draggedNode = node;
                node.classList.add('is-dragging');
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/plain', node.id || '');
            });

            // Drag Over
            node.addEventListener('dragover', (e) => {
                e.preventDefault();
                e.stopPropagation();
                const dragged = window.DT_HIERARCHY.draggedNode;
                if (!dragged || dragged === node || node.contains(dragged)) return;

                // Restrict dragging to same hierarchy parent list
                if (dragged.parentNode !== node.parentNode) return;

                e.dataTransfer.dropEffect = 'move';
                const rect = node.getBoundingClientRect();
                const midY = rect.top + rect.height / 2;

                if (e.clientY < midY) {
                    node.classList.add('drag-over-top');
                    node.classList.remove('drag-over-bottom');
                } else {
                    node.classList.add('drag-over-bottom');
                    node.classList.remove('drag-over-top');
                }
            });

            // Drag Leave
            node.addEventListener('dragleave', (e) => {
                e.stopPropagation();
                node.classList.remove('drag-over-top', 'drag-over-bottom');
            });

            // Drop
            node.addEventListener('drop', (e) => {
                e.preventDefault();
                e.stopPropagation();
                const dragged = window.DT_HIERARCHY.draggedNode;
                if (!dragged || dragged === node || node.contains(dragged)) {
                    node.classList.remove('drag-over-top', 'drag-over-bottom');
                    return;
                }

                if (dragged.parentNode === node.parentNode) {
                    const rect = node.getBoundingClientRect();
                    const midY = rect.top + rect.height / 2;
                    if (e.clientY < midY) {
                        node.parentNode.insertBefore(dragged, node);
                    } else {
                        node.parentNode.insertBefore(dragged, node.nextElementSibling);
                    }
                    
                    const title = dragged.querySelector('.dt-tree-item a, .dt-tree-item span')?.textContent?.trim() || 'Category';
                    if (window.DT_CATALOGUE) {
                        window.DT_CATALOGUE.showToast(`✅ Reordered: ${title}`);
                    }
                }

                node.classList.remove('drag-over-top', 'drag-over-bottom');
            });

            // Drag End
            node.addEventListener('dragend', (e) => {
                e.stopPropagation();
                node.classList.remove('is-dragging');
                document.querySelectorAll('.dt-tree-node').forEach(n => {
                    n.classList.remove('drag-over-top', 'drag-over-bottom', 'is-dragging');
                });
                window.DT_HIERARCHY.draggedNode = null;
            });
        });
    }
};

// Auto-initialize on load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => window.DT_HIERARCHY.initDragAndDrop());
} else {
    window.DT_HIERARCHY.initDragAndDrop();
}
