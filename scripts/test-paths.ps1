$basePath = 'C:\Users\sai\Desktop\DT Reseller HUB'
$includeDirs = @('src','config','database')

foreach ($dir in $includeDirs) {
    $from = Join-Path $basePath $dir
    if (Test-Path $from -PathType Container) {
        Write-Host "FOUND: $from" -ForegroundColor Green
        $count = (Get-ChildItem -Path $from -Recurse -File | Measure-Object).Count
        Write-Host "  File count: $count"
    } else {
        Write-Host "MISSING: $from" -ForegroundColor Red
    }
}