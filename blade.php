<?php

/** @var \Illuminate\View\Compilers\BladeCompiler $bladeCompiler */
$bladeCompiler->directive('markdown', function ($value) {
    return "<?php echo \Illuminate\Support\Str::markdown((string) $value); ?>";
});
