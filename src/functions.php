<?php

function debugger()
{
  return '$__debugger = resolve("Nolanpro\Tbp\Debugger"); extract($__debugger->call(get_defined_vars(), isset($this) ? $this : @get_called_class()));';
}