<?php

namespace App\Machine;

/**
 * Class CigaretteMachine
 * @package App\Machine
 */
class CigaretteMachine implements MachineInterface
{
    const ITEM_PRICE = 4.99;

    public function execute(PurchaseTransactionInterface $purchaseTransaction)
    {
        // TODO: Implement execute() method.
    }
}