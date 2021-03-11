<?php declare(strict_types=1);

namespace Marartner\PsalmStrictEquality;

use Marartner\PsalmStrictEquality\Hooks\StrictEqualityHook;
use SimpleXMLElement;
use Psalm\Plugin\PluginEntryPointInterface;
use Psalm\Plugin\RegistrationInterface;
use function class_exists;

class Plugin implements PluginEntryPointInterface
{
    public function __invoke(RegistrationInterface $registration, ?SimpleXMLElement $config = null): void
    {
        if(class_exists(StrictEqualityHook::class)){
            $registration->registerHooksFromClass(StrictEqualityHook::class);
        }
    }
}

