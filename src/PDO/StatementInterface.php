<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO;

/**
 * Class ClauseContainer.
 *
 * @author Fabian de Laender <fabian@faapz.nl>
 */
interface StatementInterface
{
    /**
     * @return array
     */
    public function getValues();

    /**
     * @return string
     */
    public function __toString();
}
