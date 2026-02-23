# Dead Code & Debug Code Found in Repository

## Summary
Found extensive commented-out debug code, var_dump() calls, die() statements, and HAX comments throughout the codebase that should be removed.

---

## 1. CRITICAL - Active Debug Code (Must Remove)

### NewAdvancedSearchController.php
- **Line 273-274**: `var_dump($JoinFinal); die();` - COMMENTED OUT but visible
- **Line 286-288**: `var_dump($cadSql)` and `var_dump($cadSqlNot)` - COMMENTED OUT
- **Line 539**: `dd($quries);` - **ACTIVE** (will crash if reached)

### compare.blade.php (Blade Template)
- **Line 683-684**: `var_dump($datos); die();` - **ACTIVE** (will crash page)

---

## 2. Commented-Out Debug Code (Should Remove)

### NewAdvancedSearchController.php
- Line 148: `//var_dump($filtrosPrincipales['label']);`
- Line 264: `//die();`
- Line 302: `// var_dump($IdListNot);`
- Line 498-499: `//var_dump($data);` and `//die();`
- Line 511: `//var_dump($listIDs);die();`
- Line 535: `//dd($ResultadoDBSQL);`
- Line 646-647: `//var_dump($comparaciones);` and `//die();`
- Line 732: `// var_dump($filtrosAplicados);`
- Line 753-754: `//var_dump($datosFomulario);` and `//die();`
- Line 831: `//  var_dump($request);`

### compare.blade.php
- Line 83: `//var_dump($dataNum);`
- Line 535: `//var_dump($datos);die();` (duplicate)
- Line 540-541: `//var_dump($datos);` and `//die();`
- Line 574: `//dd($value);`
- Line 641: `//var_Dump($value);`
- Line 643: `//var_dump($indices);`
- Line 645: `//die();`
- Line 658-659: `//var_dump($linea);` and `//die();`
- Line 815: `//var_Dump($value2);die();`
- Line 833: `//var_dump($DataStr);die();`

### results.blade.php
- Line 63-64: `//var_dump($allSession);` and `// die();`
- Line 120: `//var_dump($tempData);die();`

### statistics/results.blade.php
- Line 11: `*  var_dump($trayectoria);` (commented in docstring)

### statistics/totals.blade.php
- Line 10: `*  var_dump($trayectoria);` (commented in docstring)

### filtros/busqueda_avanzada_selects.blade.php
- Line 8: `//var_dump($filtro);`
- Line 38: `//var_dump($options);`

### ImageController.php
- Line 48: `//  dd("Document has been converted");`

### Trayectoria.php
- Line 55: `// dd(DB::getQueryLog());`

### SearchController.php
- Line 57: `// dd(DB::getQueryLog());`

---

## 3. HAX / TODO Comments

### NewAdvancedSearchController.php
- **Line 220**: `// Esto es un Hack para el ranking_global` - Calculates tolerance for numeric values
- **Line 254**: `// Esta cadena es un inner join especia para todos los temas de And OR y NOT.. not no esta del todo OK`
- **Line 451**: `// HACK :: para que salga la temperatura con un slide de seleccion...`

### compare.blade.php
- **Line 193**: `// HACK THIS LABEL IS GONNA GOT TO HEAD GROUP`
- **Line 576**: `// HACK!!!!!  ESTO NO SE PUEDE HACER, POR QUE SE CARGA LAS GRAFICAS` - Disables quality filter to avoid breaking charts

### formulario_copia.blade.php
- **Line 363**: `// HACK`

### form.blade.php
- **Line 424**: `// HACK`

---

## 4. Commented-Out Conditional Logic (Dead Code)

### compare.blade.php
- Line 260: `//if (data2 != '')`
- Line 579: `//if ($value->quality_total != 0 && $value->quality_headgroups != 0 && $value->quality_tails) {`
- Line 607: `//if (is_array($qualityTotal) && count($qualityTotal) > 0)`
- Line 612: `//if (is_array($bilayer_thickness) && count($bilayer_thickness) > 0)`
- Line 616: `//if (is_array($area_per_lipid) && count($area_per_lipid) > 0)`
- Line 941: `//if (is_array($qualityTotal) && count($qualityTotal) > 0 && is_array($bilayer_thickness) && count($bilayer_thickness) > 0 && is_array($area_per_lipid) && count($area_per_lipid) > 0) {`
- Line 962: `//if (!$bilayer_thickness_value_process.length === 0) {`
- Line 975: `//if (!$area_per_lipid_value_process.length === 0) {`

### SearchController.php
- Line 27: `//if (!is_null($trayectoria)) {`

### results.blade.php
- Line 176: `//if (strlen(implode(', ',$tempData['ion_short_name']))>0){`

### filtros/busqueda_avanzada_selects.blade.php
- Line 25: `//if (isset($filtro->unidades)) echo ($filtro->unidades)`

---

## 5. Suspicious/Unfinished Code

### lipidos/show.blade.php
- **Line 17**: `<div class="card-header  bg-white">Lipido xxx</div>` - Placeholder text "xxx"

---

## 6. Large Commented-Out Blocks (Over 10 lines)

### compare.blade.php
- Lines ~900+: Large commented JavaScript block for form factor form factor chart code

---

## Recommendations

### Priority 1 - MUST FIX
1. **Remove Line 539** in NewAdvancedSearchController.php: `dd($quries);` - This will crash the application
2. **Remove Lines 683-684** in compare.blade.php: `var_dump($datos); die();` - This breaks the page

### Priority 2 - Should Clean
1. Remove all commented-out debug statements (var_dump/die/dd) across all files
2. Remove or implement HAX comments - especially line 576 in compare.blade.php (disables quality filter)
3. Clean up "ESTO NO SE PUEDE HACER" comment - indicates unfinished/problematic logic

### Priority 3 - Nice to Have
1. Remove all commented-out conditional blocks
2. Fix placeholder text "Lipido xxx" in show.blade.php
3. Add proper error handling instead of die() statements

---

## Files Most Affected
1. `/var/www/html/app/Http/Controllers/NewAdvancedSearchController.php` - 20+ debug statements
2. `/var/www/html/resources/views/new_advanced_search/compare.blade.php` - 15+ debug statements
3. `/var/www/html/resources/views/new_advanced_search/results.blade.php` - Multiple debug statements

