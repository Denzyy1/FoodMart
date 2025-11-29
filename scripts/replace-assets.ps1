$p='c:\xampp\foodmart-app\resources\views\dashboard.blade.php'
$c=Get-Content -Raw $p
$c=[regex]::Replace($c,'src="images/([^"]+)"','src="{{ asset(''admin/images/$1'') }}"')
$c=[regex]::Replace($c,"url\('images/([^']+)'\)",'url(\'{{ asset(''admin/images/$1'') }}\')')
$c=[regex]::Replace($c,'<script src="js/([^"]+)"></script>','<script src="{{ asset(''admin/js/$1'') }}"></script>')
Set-Content -Path $p -Value $c -Encoding UTF8
Write-Output 'Replacements complete'
