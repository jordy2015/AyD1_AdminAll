Feature: descuentos
  es una funcion que me permite como administrador
  poder descontarles a mis empleados con solo ingresar 
  el ID del empleado, la cantidad a descontar y un descripcion
  del porque se le esta descontado al empleado.

Scenario: Descontar a un empleado con resultado exitoso
  Given yo como gerente 
  And tengo un empleado con ID 200
  And deceo descontar 7 quetzales de su suldo del empleado ID 2  
  When al empleado se penalice por una determinada accion descontando 7 quetzales al empleado con ID 2
  Then I should get:
    """
    exito
    """