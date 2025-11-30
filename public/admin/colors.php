<?php
require "./middle/auth.php";

$configPath =  "../../data/config.json";
$cssPath =  "../assets/style.css";

$colorVars = [
    "Botones" => "color-primary",
    "Botones hover" => "color-primary-hover",
    "Fondo" => "color-bg",
    "Fondo 2" => "color-secondary-bg",
    "Fondo 3" => "color-secondary-bg-dark",
    "Texto" => "color-text",
    "Texto 2" => "color-text-secondary",
    "texto 3" => "color-text-secondary-dark"
];

$config = json_decode(file_get_contents($configPath), true);

// guardado del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    foreach ($colorVars as $var) {
        $config['lightColors'][$var] = $_POST['light'][$var];
    }
    foreach ($colorVars as $var) {
        $config['darkColors'][$var] = $_POST['dark'][$var];
    }
    file_put_contents($configPath, json_encode($config, JSON_PRETTY_PRINT));

    // reescribir CSS
    $css = ":root {\n";
    foreach ($config['lightColors'] as $key=>$var) {
        $css .= "    --{$key}: {$var};\n";
    }
    $css .= "}\n\n@media (prefers-color-scheme: dark) {\n  :root {\n";
    foreach ($config['darkColors'] as $key=>$var) {
        $css .= "    --{$key}: {$var};\n";
    }
    $css .= "  }\n}\n";
    file_put_contents($cssPath, $css);
    $message = "🎉 Colores actualizados correctamente";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<script src="https://cdn.tailwindcss.com"></script>
<title>Editar colores</title>
</head>

<body class="bg-bg text-text-main p-8">
<div class="max-w-4xl mx-auto bg-secondary-bg p-8 rounded-xl shadow-lg">

    <h1 class="text-3xl font-bold mb-6 text-center">Editar Paleta de Colores</h1>

    <?php if (!empty($message)): ?>
    <div class="bg-primary p-3 rounded mb-4 text-center"><?= $message ?></div>
    <?php endif; ?>

    <form method="post" class="grid gap-6">
	<h3>Tema Claro</h3>
	<div class="grid grid-cols-4 gap-12">
        <?php foreach ($colorVars as $k=>$v): ?>
        <div>
            <label class="font-semibold block mb-1"><?= $k ?></label>
            <input type="color" name="light[<?= $v ?>]" value="<?= $config['lightColors'][$v] ?? '#000000' ?>"
                   class="w-full p-2 rounded border border-gray-400">
        </div>
        <?php endforeach; ?>
        </div>
	<h3>Tema Osucro</h3>
	<div class="grid grid-cols-4 gap-12">
	<?php foreach ($colorVars as $k=>$v): ?>
        <div>
            <label class="font-semibold block mb-1"><?= $k ?></label>
            <input type="color" name="dark[<?= $v ?>]" value="<?= $config['darkColors'][$v] ?? '#000000' ?>"
                   class="w-full p-2 rounded border border-gray-400">
        </div>
        <?php endforeach; ?>
        </div>
	

        <button class="col-span-full bg-primary hover:bg-primary-hover py-3 rounded-lg font-bold mt-4">
            Guardar cambios
        </button>
    </form>

</div>
</body>
</html>

