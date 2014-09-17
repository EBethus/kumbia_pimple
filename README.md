kumbia_pimple
=============

Prueba de un refactoring de kumbiaphp basado en pimple y componentes de symfony.

## Por ahora tiene

 * Manejo de router para controllers estilo KumbiaPHP (pero sin módulos).
 * Manejo de Redirecciones estilo KumbiaPHP (Redirect::to() y Redirect::toAction()).
 * Manejo del Request (Input::get(), Input::post(), Input::hasPost(), Input::isAjax()).
 
Además aporta todos los beneficios de la DependencyInjection y agregar escuchas de eventos para extender las funcionalidades en las aplicaciones.

### Pros
  
 * Facil Añadir extensiones y plugins.
 * Facil de Extender y configurar o reescribir cualquier parte.

### Contras

 * Unas 3 Veces más lento que KumbiaPHP.
 * Más consumo de Memoria (No se ha verificado Cuanto).
