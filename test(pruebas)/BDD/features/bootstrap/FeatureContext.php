<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */


    /**
     * @Given /^yo como gerente$/
     */
    public function yoComoGerente()
    {
        $dbh = new PDO('mysql:host=localhost;port=3306;dbname=pract1', 'root', '123456789', array( PDO::ATTR_PERSISTENT => false));
        $stmt = $dbh->prepare("SELECT `empleado`.`empleado` FROM `pract1`.`empleado` where `empleado`.`empleado`=1;");
        // call the stored procedure
        $stmt->execute();
      // fetch all rows into an array.
        $rows = $stmt->fetchAll();

        if (!$rows) {
            throw new Exception(
                "Error no admin" 
            );
        }
        //throw new PendingException();
    }

    /**
     * @Given /^tengo un empleado con ID (\d+)$/
     */
    public function tengoUnEmpleadoConId($arg1)
    {
        $dbh = new PDO('mysql:host=localhost;port=3306;dbname=pract1', 'root', '123456789', array( PDO::ATTR_PERSISTENT => false));
        $stmt = $dbh->prepare("SELECT `empleado`.`empleado` FROM `pract1`.`empleado` where `empleado`.`empleado`=".$arg1.";");
        // call the stored procedure
        $stmt->execute();
      // fetch all rows into an array.
        $rows = $stmt->fetchAll();

        if (!$rows) {
            throw new Exception(
                "Error no existe" 
            );
        }
    }

    /**
     * @Given /^deceo descontar (\d+) quetzales de su suldo del empleado ID (\d+)$/
     */
    public function deceoDescontarQuetzalesDeSuSuldoDelEmpleadoId($arg1, $arg2)
    {
        return true;
       // throw new PendingException();
    }

    /**
     * @When /^al empleado se penalice por una determinada accion descontando (\d+) quetzales al empleado con ID (\d+)$/
     */
    public function alEmpleadoSePenalicePorUnaDeterminadaAccionDescontandoQuetzalesAlEmpleadoConId($arg1, $arg2)
    {
        $dbh = new PDO('mysql:host=localhost;port=3306;dbname=pract1', 'root', '123456789', array( PDO::ATTR_PERSISTENT => false));
        $stmt = $dbh->prepare("CALL `pract1`.`Descontar`(".$arg2.",'Descuento de prueba','".$arg1."');");
        // call the stored procedure
        $stmt->execute();
        $this->output ="exito";

    }


    /**
     * @Then /^I should get:$/
     */
    public function iShouldGet(PyStringNode $string)
    {
        if ((string) $string !== $this->output) {
            throw new Exception(
                "Actual output is:\n" . $this->output
            );
        }
    }


//
// Place your definition and hook methods here:
//
//    /**
//     * @Given /^I have done something with "([^"]*)"$/
//     */
//    public function iHaveDoneSomethingWith($argument)
//    {
//        doSomethingWith($argument);
//    }
//
}
