<?php

require __DIR__ . '/vendor/autoload.php';

set_error_handler(function($severity, $message, $file, $line) {
    if (str_contains($file, 'swagger-php')) {
        return true;
    }
    echo "Warning: $message\n";
    return true;
});

try {
    $generator = new \OpenApi\Generator();
    $analyser = new \OpenApi\Analysers\ReflectionAnalyser([
        new \OpenApi\Analysers\DocBlockAnnotationFactory(),
        new \OpenApi\Analysers\AttributeAnnotationFactory(),
    ]);

    $openapi = $generator->setAnalyser($analyser)->generate([__DIR__ . '/app']);
    $json = $openapi->toJson();
    file_put_contents(__DIR__ . '/storage/api-docs/api-docs.json', $json);
    echo "Swagger generado exitosamente! (" . strlen($json) . " bytes)\n";
} catch (\Throwable $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}
