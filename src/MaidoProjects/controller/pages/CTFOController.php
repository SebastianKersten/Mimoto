<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MaidoProjects\Controller\pages;


use Silex\Application;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;


/**
 * Description of newPHPClass
 *
 * @author apple
 */
class CTFOController
{
    
    // prices
    const PRICE_YEAR            = 60;
    const PRICE_MONTH           = 6;
    const PRICE_GIFT_3MONTHS    = 18;
    const PRICE_GIFT_12MONTHS   = 60;
    
    // unspecified
    const UNSPECIFIED                   = 'De Correspondent';
    const REFUND_UNSPECIFIED            = 'Refund: De Correspondent';
    
    // yearly memberships
    const YEAR                          = 'De Correspondent - Lidmaatschap 1 jaar';
    const YEAR_DONATION                 = 'De Correspondent - Lidmaatschap 1 jaar & Donatie';
    const YEAR_RENEW                    = 'De Correspondent - Verlenging lidmaatschap 1 jaar';
    const YEAR_RENEW_DONATION           = 'De Correspondent - Verlenging lidmaatschap 1 jaar & Donatie';
    const REFUND_YEAR                   = 'Refund: De Correspondent  Lidmaatschap 1 jaar';
    const REFUND_YEAR_DONATION          = 'Refund: De Correspondent  Lidmaatschap 1 jaar  Donatie';
    const REFUND_YEAR_RENEW             = 'Refund: De Correspondent  Verlenging lidmaatschap 1 jaar';
    const REFUND_YEAR_RENEW_DONATION    = 'Refund: De Correspondent  Verlenging lidmaatschap 1 jaar  Donatie';
    
    // monthly memberships
    const MONTH                         = 'De Correspondent - Lidmaatschap 1 maand';
    const MONTH_DONATION                = 'De Correspondent - Lidmaatschap 1 maand & Donatie';
    const MONTH_RENEW                   = 'De Correspondent - Verlenging lidmaatschap 1 maand';
    const MONTH_RENEW_DONATION          = 'De Correspondent - Verlenging lidmaatschap 1 maand & Donatie';
    const REFUND_MONTH                  = 'Refund: De Correspondent  Lidmaatschap 1 maand';
    const REFUND_MONTH_DONATION         = 'Refund: De Correspondent  Lidmaatschap 1 maand  Donatie';
    const REFUND_MONTH_RENEW            = 'Refund: De Correspondent  Verlenging lidmaatschap 1 maand';
    const REFUND_MONTH_RENEW_DONATION   = 'Refund: De Correspondent  Verlenging lidmaatschap 1 maand  Donatie';
    
    // donation
    const DONATION                      = 'De Correspondent - Donatie';
        
    // gift 3 months
    const GIFT_3MONTHS                  = 'De Correspondent - Cadeau lidmaatschap 3 maanden';
    const REFUND_GIFT_3MONTH            = 'Refund: De Correspondent  Cadeau lidmaatschap 3 maanden';
        
    // gift 12 months
    const GIFT_12MONTHS                 = 'De Correspondent - Cadeau lidmaatschap 1 jaar';
    
    
    
    var $_aTransactions = array();
    
    
    public function analyzeBuckaroo(Application $app)
    {   
        
        $aDescriptionUitzonderlijkeStortingen = array(
            "aparte storting door Mw J F R Dijkstra en/of Mw A E de Groot op 7 november 2014 via Buckaroo",
            "Refund: De Correspondent Lidmaatschap 1 jaar Donatie BuckID: FFJP79ERSK836IV9QPKN",
            "Terugstorting: De Correspondent Verlenging lidmaatschap 1 jaar - Resterende 9 maanden BuckID: DQQVDW",
            "crs20150708357769",
            "De Correspondent - Verlenging lidmaatschap 1 jaar (rfd) BuckID: YLARAOGY1YGCQMNQEY4F",
            "De Correspondent - Verlenging lidmaatschap 1 jaar (rfd) BuckID: ZT8DIRDHMW4HSLJ8HWVX",
            "De Correspondent - Verlenging lidmaatschap 1 jaar (rfd) BuckID: DTE8ISNGYCY34H8PFNTU",
            "crs1535700000142545"
        );
        
        $aPartialRefunds = array(
            'Terugstorting: De Correspondent Verlenging lidmaatschap 1 jaar',
            'Terugstorting: De Correspondent  Lidmaatschap 1 jaar - Annulering',
            'Terugstorting: De Correspondent  Cadeau lidmaatschap 1 jaar - Annulering',
            "Refund: De Correspondent Resterende 10 maanden",
            "Terugstorting: De Correspondent resterende 9 maanden van lidmaatschap",
            "Terugstorting: De Correspondent Verlenging lidmaatschap 1 jaar - resterende 11 maanden",
            "Terugstorting: De Correspondent  Verlenging lidmaatschap 1 jaar - Resterende 9 maanden",
            "Terugstorting: Jaarlidmaatschap De Correspondent - Resterende 8 maanden",
            "Terugstorting: De Correspondent  Verlenging lidmaatschap 1 jaar - resterende 10 maanden",
            "Terugstorting: De Correspondent  Verlenging lidmaatschap 1 jaar - resterende 11 maanden",
            "Terugstorting: De Correspondent  Verlenging lidmaatschap 1 jaar - Resterende 11 maanden",
            "Terugstorting: De Correspondent  Verlenging lidmaatschap 1 jaar - i.v.m. dubbele afschrijving",
            "Terugstorting: De Correspondent  Verlenging lidmaatschap 1 jaar - i.v.m. dubbele betaling",
            "Terugstorting: De Correspondent  Verlenging lidmaatschap 1 jaar - resterende 9 maanden",
            "Terugstorting: De Correspondent  Verlenging lidmaatschap 1 jaar",
            "Terugstorting: De Correspondent  Lidmaatschap 1 jaar - geannuleerd lidmaatschap",
            "Terugstorting: De Correspondent  Verlenging lidmaatschap 1 jaar -Resterende 9 maanden",
            "Terugstorting: De Correspondent  Lidmaatschap 1 jaar  Donatie - annulering",
            "Terugstorting: De Correspondent  Lidmaatschap 1 jaar - annulering lidmaatschap",
            "Terugstorting: De Correspondent Verlenging lidmaatschap 1 jaar - Resterende 9 maanden",
            "Terugstorting: De Correspondent  Verlenging lidmaatschap 1 jaar - Resterende 10 maanden",
            "Terugstorting: De Correspondent  Lidmaatschap 1 jaar - i.v.m. dubbele betaling",
            "Terugstorting: De Correspondent  Lidmaatschap 1 jaar  Donatie",
            "Terugstorting: verlenging 1 jaar De Correspondent - Resterende 6 maanden",
            "Terugstorting: De Correspondent  Verlenging lidmaatschap 1 jaar - Resterende 7 maanden",
            "Terugstorting: De Correspondent  Verlenging lidmaatschap 1 jaar - Resterende 6 maanden",
            "Gedeeltelijke terugstorting: De Correspondent  Lidmaatschap 1 jaar - Donatie (€50,-)",
            "Terugstorting: De Correspondent  Verlenging lidmaatschap 1 jaar - Resterende 8 maanden",
            "Refund: De Correspondent  Cadeau lidmaatschap 1 jaar",
            "De Correspondent - Verlenging lidmaatschap 1 jaar(refund)",
            "De Correspondent - Verlenging lidmaatschap 1 jaar (rfd)",
            "De Correspondent - Verlenging lidmaatschap 1 maand (rfd)",
            "De Correspondent - Verlenging lidmaatschap 1 jaar & Donatie (rfd)",
            "De Correspondent - Lidmaatschap 1 jaar (rfd)",
            "De Correspondent - Cadeau lidmaatschap 1 jaar (rfd)",
            "De Correspondent - Lidmaatschap 1 jaar & Donatie (rfd)",
            "De Correspondent - Cadeau lidmaatschap 3 maanden (rfd)",
            "De Correspondent - Verlenging lidmaatschap 1 maand & Donatie (rfd)",
            "De Correspondent - Lidmaatschap 1 maand (rfd)"
        );
        
        $aCreditNotas = array(
            "Creditnota NL00284708",
            "Creditnota NL00284709",
            "Creditnota NL00284710",
            "Creditnota NL00284711",
            "Creditnota NL00284712",
            "Creditnota NL00284713"
        );
        
        
        $aFiles = array();

        if ($dirhandle = opendir(dirname(__FILE__)."/CTFO-Payouts")) {
            while (false !== ($entry = readdir($dirhandle))) {
                if ($entry != "." && $entry != "..") {
                    
                    if (preg_match('/Payout - [0-9]{4}\.[0-9]{2}\.[0-9]{2}\.csv/', $entry) === 1)
                    {
                        $sFileName = dirname(__FILE__)."/CTFO-Payouts/".$entry;
                        
                        $handle = fopen($sFileName, "r");
                        $contents = fread($handle, filesize($sFileName));
                        fclose($handle);
                        
                        $aFiles[] = (object) array(
                            'name' => $entry,
                            'date' => substr($entry, 9, 10),
                            'contents' => $contents
                        );
                    }
                }
            }
            closedir($dirhandle);
        }
        
        
        //echo "Number of files = ".count($aFiles).'<br><br>';
        
        
        for ($nFileCount = 0; $nFileCount < count($aFiles); $nFileCount++)
        {
            
            // start new file
           // echo "<h3><b>".$aFiles[$nFileCount]->name."</b></h3><br>";
            $aLines = explode("\n", $aFiles[$nFileCount]->contents);
            //echo count($aLines)."<br>";
            

            // validate first line
            if (substr($aLines[0], 0, 103) == '"Release date","Trans date","name","Account number","Invoice","Description","Currency","Debit","Credit"')
            {
                
                // init
                $revenue = (object) array(
                    'year' => (object) array(
                        'new' => 0,                     // number of new yearly memberships
                        'renew' => 0,                   // number of renewed tearly memberships
                        'refund_new' => 0,              // number of fully refunded new yearly memberships
                        'refund_renew' => 0,            // number of fully refunded renewed yearly memberships
                        'donations' => array(),         // number of yearly membership donations
                        'donation_refunds' => array()   // number of fully refunded yearly membership donations
                    ),
                    'month' => (object) array(
                        'new' => 0,                     // number of new monthly memberships
                        'renew' => 0,                   // number of renewed monthly memberships
                        'refund_new' => 0,              // number of fully refunded new monthly memberships
                        'refund_renew' => 0,            // number of fully refunded renewed monthly memberships
                        'donations' => array(),         // number of monthly membership donations
                        'donation_refunds' => array()   // number of fully refunded yearly membership donations
                     ),
                    'donations' => (object) array(
                        'new' => array(),               // number of donations
                        'refunds' => array(),           // number of refunded donations
                    ),
                    'gift_3months' => (object) array(
                        'amount' => 0,                  // number of 3 month gifts sold
                        'donations' => array(),         // number of 3 month gift donations
                        'refunds' => 0                  // number of refunded 3 month gifts
                    ),
                    'gift_12months' => (object) array(  
                        'amount' => 0,                  // number of 12 month gifts sold
                        'donations' => array(),         // number of 12 month gift donations
                        'refunds' => 0                  // number of refunded 12 month gifts
                    ),
                    'income' => (object) array(
                        'year_new' => 0,                // amount of income from new yearly memberships
                        'year_renew' => 0,              // amount of income from renewed yearly memberships
                        'month_new' => 0,               // amount of income from new monthly memberships
                        'month_renew' => 0,             // amount of income from renewed yearly memberships
                        'gift_3months' => 0,            // amount of income from 3 month gifts
                        'gift_12months' => 0,           // amount of income from 12 month gifts
                        'donations' => 0,               // amount of income from donations
                        'exceptionaldeposits' => 0      // amount of income from exceptional deposits
                    ),
                    'expenses' => (object) array(
                        'transactioncosts' => 0,        // amount of transaction consts
                        'refunds_year_new' => 0,        // amount of refunds of new yearly memberships
                        'refunds_year_renew' => 0,      // amount of refunds of renewed yearly memberships
                        'refunds_month_new' => 0,       // amount of refunds of new monthly memberships
                        'refunds_month_renew' => 0,     // amount of refunds of renewed monthly memberships
                        'refunds_gift_3mnd' => 0,       // amount of refunds of 3 month gifts
                        'refunds_gift_12mnd' => 0,      // amount of refunds of 12 month gifts
                        'refunds_donations' => 0,       // amount of refunds of donations
                        'partial_refunds' => 0          // amount of partial refunds (#todo - needs refinement?)
                    ),
                    'payment' => 0,                     // payments received from Buckaroo
                    'creditnotas' => 0                  // credit notes received from Buckaroo
                );
                
                
                // parse data lines
                for ($i = 1; $i < count($aLines); $i++)
                {

                    if (strlen($aLines[$i]) == 0) continue;

                    $aLineParts = explode('","', $aLines[$i]);

                    for ($j = 0; $j < count($aLineParts); $j++)
                    {
                        // cleanup
                        if (substr($aLineParts[$j], 0, 1) == '"') $aLineParts[$j] = substr($aLineParts[$j], 1);

                        $pos = strpos($aLineParts[$j], '"');
                        if ($pos !== false) $aLineParts[$j] = substr($aLineParts[$j], 0, $pos);
                    }

                    $payment = (object) array(
                        'ReleaseDate' => $aLineParts[0],
                        'TranDate' => $aLineParts[1],
                        'Name' => $aLineParts[2],
                        'AccountNumber' => $aLineParts[3],
                        'Invoice' => $aLineParts[4],
                        'Description' => $aLineParts[5],
                        'Currency' => $aLineParts[6],
                        'Debit' => $aLineParts[7],
                        'Credit' => $aLineParts[8]
                    );

                    
                    // correct for easy parsing
                    if (substr($payment->Description, 0, 22) == "Uitbetaling ".$payment->ReleaseDate) $payment->Description = substr($payment->Description, 0, 22);
                    
                    
                    
                    switch($payment->Description)
                    {
                        case "Uitbetaling ".$payment->ReleaseDate:
                            
                            $revenue->payment += $payment->Credit;
                            break;
                        
                        case "Transactiekosten ".$payment->ReleaseDate:
                            
                            $revenue->expenses->transactioncosts += $payment->Credit;
                            break;
                        
                        case $this::YEAR:
                        case $this::YEAR_DONATION:
                        case $this::YEAR_RENEW:
                        case $this::YEAR_RENEW_DONATION:
                            
                            $this->addYear($revenue, $payment->Description, $payment->Debit, $payment->TranDate);
                            break;
                        
                        case $this::REFUND_YEAR:
                        case $this::REFUND_YEAR_DONATION:
                        case $this::REFUND_YEAR_RENEW:
                        case $this::REFUND_YEAR_RENEW_DONATION:
                            
                            $this->subtractYear($revenue, $payment->Description, $payment->Credit);
                            break;
                            
                        case $this::MONTH:
                        case $this::MONTH_DONATION:
                        case $this::MONTH_RENEW:
                        case $this::MONTH_RENEW_DONATION:    
                            
                            $this->addMonth($revenue, $payment->Description, $payment->Debit, $payment->TranDate);
                            break;
                        
                        case $this::REFUND_MONTH:
                        case $this::REFUND_MONTH_DONATION:
                        case $this::REFUND_MONTH_RENEW:
                        case $this::REFUND_MONTH_RENEW_DONATION:
                            
                            $this->subtractMonth($revenue, $payment->Description, $payment->Credit);
                            break;
                        
                        case $this::GIFT_3MONTHS:
                            
                            $this->addGift3Months($revenue, $payment->TranDate);
                            break;
                        
                        case $this::REFUND_GIFT_3MONTH:
                            
                            $this->subtractGift3Months($revenue);
                            break;
                        
                        case $this::GIFT_12MONTHS:
                            
                            $this->addGift12Months($revenue, $payment->TranDate);
                            break;
                        
                        
                        // #todo ------------------------------ !!!
                        
                        case $this::DONATION:
                            
                            // correct
                            $nDonationAmount = floatval($payment->Debit);

                            // validate
                            if ($nDonationAmount > 0)
                            {
                                // create key (without unnecessary decimals)
                                if (!isset($revenue->donations->new[$nDonationAmount])) { $revenue->donations->new[$nDonationAmount] = 0; }

                                // register
                                $revenue->donations->new[$nDonationAmount]++;
                                $revenue->income->donations += $nDonationAmount;
                            }
                            break;
                        
                        DEFAULT:
                            
                            if (in_array($payment->Description, $aCreditNotas))
                            {
                                $revenue->creditnotas += $payment->Debit;
                            }
                            else
                            if (in_array($payment->Description, $aDescriptionUitzonderlijkeStortingen))
                            {
                                $revenue->income->exceptionaldeposits += $payment->Debit;
                            }
                            else
                            if (in_array($payment->Description, $aPartialRefunds))
                            {
                                $revenue->expenses->partial_refunds += $payment->Credit;
                            }
                            else
                            {
                                
                                switch($payment->Description)
                                {
                                    case $this::UNSPECIFIED:
                                    case $this::REFUND_UNSPECIFIED:
                                        
                                        if ($payment->Debit > 0)
                                        {
                                            if ($payment->Debit == $this::PRICE_GIFT_3MONTHS)
                                            {
                                               $this->addGift3Months($revenue, $payment->TranDate);
                                            }
                                            else
                                            if ($payment->Debit >= $this::PRICE_YEAR)
                                            {
                                               $this->addYear($revenue, $payment->Description, $payment->Debit, $payment->TranDate);
                                            }
                                            else
                                            {
                                                // correct
                                                $nDonationAmount = floatval($payment->Debit);

                                                // validate
                                                if ($nDonationAmount > 0)
                                                {
                                                    // create key (without unnecessary decimals)
                                                    if (!isset($revenue->donations->new[$nDonationAmount])) { $revenue->donations->new[$nDonationAmount] = 0; }

                                                    // register
                                                    $revenue->donations->new[$nDonationAmount]++;
                                                    $revenue->income->donations += $nDonationAmount;
                                                }
                                            }
                                        }
                                        
                                        if ($payment->Credit > 0)
                                        {
                                            if ($payment->Credit == $this::PRICE_GIFT_3MONTHS)
                                            {
                                               $this->subtractGift3Months($revenue);
                                            }
                                            else
                                            if ($payment->Credit >= $this::PRICE_YEAR)
                                            {
                                               $this->subtractYear($revenue, $payment->Description, $payment->Credit);
                                            }
                                            else
                                            {
                                                // correct
                                                $nDonationAmount = floatval($payment->Credit);

                                                // validate
                                                if ($nDonationAmount > 0)
                                                {
                                                    // create key (without unnecessary decimals)
                                                    if (!isset($revenue->donations->refunds[$nDonationAmount])) { $revenue->donations->refunds[$nDonationAmount] = 0; }

                                                    // register
                                                    $revenue->donations->refunds[$nDonationAmount]++;
                                                    $revenue->expenses->refunds_donations += $nDonationAmount;
                                                }
                                            }
                                        }
                                        
                                        break;
                                        
                                    DEFAULT:
                                        
                                        echo "<hr>";
                                        echo "strlen = ".strlen($aLines[$i])."<br>";
                                        print_r($payment);
                                        echo "[".$payment->Description."]<br>";
                                        die('Unknown line #'.$i.' in file '.$aFiles[$nFileCount]->name);
                                }
                            }
                    }             

                }

                $aFiles[$nFileCount]->revenue = $revenue;
            }
            
            // TODO
            // validate
            //if (count($aLines)
            
        }
        
        
        // #todo omvormen tot plotbare dataset
        
        
        
        $data = (object) array();
        $totals = (object) array();
        
        
        
        
        $data->donationTypes = array();
        $data->donationRefundTypes = array();
        
        
        
        for ($i = 0; $i < count($aFiles); $i++)
        {
            
            // register
            $file = $aFiles[$i];
            $revenue = $file->revenue;
            $file->donations = array();
            
            $aDonationHolders = array(
                $revenue->year->donations,
                $revenue->month->donations, 
                $revenue->donations->new
            );
            
            $aDonationRefundHolders = array(
                $revenue->year->donation_refunds,
                $revenue->month->donation_refunds,
                $revenue->donations->refunds
            );
            
            
            for ($j = 0; $j < count($aDonationHolders); $j++)
            {
                $aDonationHolder = $aDonationHolders[$j];
                
                if (!empty($aDonationHolder))
                {
                    foreach ($aDonationHolder as $sKey => $value)
                    {
                        if (!in_array($sKey, $data->donationTypes))
                        {
                            $data->donationTypes[] = $sKey;
                            $file->donations[$sKey] = 0;
                        }
                        
                        $file->donations[$sKey] += $value;
                    }
                }
            }
            
            for ($j = 0; $j < count($aDonationRefundHolders); $j++)
            {
                $aDonationRefundHolder = $aDonationRefundHolders[$j];
                
                if (!empty($aDonationRefundHolder))
                {
                    foreach ($aDonationRefundHolder as $sKey => $value)
                    {
                        if (!in_array($sKey, $data->donationRefundTypes))
                        {
                            $data->donationRefundTypes[] = $sKey;
                            $file->donationRefunds[$sKey] = 0;
                        }
                        
                        $file->donationRefunds[$sKey] += $value;
                    }
                }
            }
        }
        
        asort($data->donationTypes);
        asort($data->donationRefundTypes);
        
        
        
        $data->records = array();
        
        $aLastRecordTotals = (object) array();
        $aLastRecordTotals->date = 'Totaal';
        $aLastRecordTotals->products = array();
        $aLastRecordTotals->refundsProducts = array();
        $aLastRecordTotals->donations = array();
        $aLastRecordTotals->donationRefunds = array();
        
        
        
        for ($i = 0; $i < count($aFiles); $i++)
        {
            
            // register
            $file = $aFiles[$i];
            $revenue = $file->revenue;
            
            // init
            $record = (object) array();
            
            $record->date = $file->date;
            
            
            // income
            
            $record->products = array(
                $revenue->year->new,
                $revenue->year->renew,
                $revenue->month->new,
                $revenue->month->renew,
                $revenue->gift_3months->amount,
                $revenue->gift_12months->amount
            );
            for ($k = 0; $k < count($record->products); $k++) $aLastRecordTotals->products[$k] += $record->products[$k];
            
            
            $nIncomeProducts =
                $revenue->year->new * $this::PRICE_YEAR +
                $revenue->year->renew * $this::PRICE_YEAR +
                $revenue->month->new * $this::PRICE_MONTH +
                $revenue->month->renew * $this::PRICE_MONTH +
                $revenue->gift_3months->amount * $this::PRICE_GIFT_3MONTHS +
                $revenue->gift_12months->amount * $this::PRICE_GIFT_12MONTHS;
            
            
            $record->incomeProductsInclVat = $nIncomeProducts;
            $record->incomeProductsExclVat = $nIncomeProducts / 1.21;
            $record->incomeProductsVat = $nIncomeProducts - $nIncomeProducts / 1.21;
            
            $aLastRecordTotals->incomeProductsInclVat += $record->incomeProductsInclVat;
            $aLastRecordTotals->incomeProductsExclVat += $record->incomeProductsExclVat;
            $aLastRecordTotals->incomeProductsVat += $record->incomeProductsVat;
            
            
            $record->refundsProducts = array(
                $revenue->year->refund_new,
                $revenue->year->refund_renew,
                $revenue->month->refund_new,
                $revenue->month->refund_renew,
                $revenue->gift_3months->refunds,
                $revenue->gift_12months->refunds
            );
            for ($k = 0; $k < count($record->refundsProducts); $k++) $aLastRecordTotals->refundsProducts[$k] += $record->refundsProducts[$k];
            
            $nRefundsProducts =
                $revenue->year->refund_new * $this::PRICE_YEAR +
                $revenue->year->refund_renew * $this::PRICE_YEAR +
                $revenue->month->refund_new * $this::PRICE_MONTH +
                $revenue->month->refund_renew * $this::PRICE_MONTH +
                $revenue->gift_3months->refunds * $this::PRICE_GIFT_3MONTHS +
                $revenue->gift_12months->refunds * $this::PRICE_GIFT_12MONTHS;
            
            $record->refundsProductsInclVat = $nRefundsProducts;
            $record->refundsProductsExclVat = $nRefundsProducts / 1.21;
            $record->refundsProductsVat = $nRefundsProducts - $nRefundsProducts / 1.21;
            
            $aLastRecordTotals->refundsProductsInclVat += $record->refundsProductsInclVat;
            $aLastRecordTotals->refundsProductsExclVat += $record->refundsProductsExclVat;
            $aLastRecordTotals->refundsProductsVat += $record->refundsProductsVat;
            
            $record->exceptionalDepositsTotal = $revenue->income->exceptionaldeposits;
            $aLastRecordTotals->exceptionalDepositsTotal += $record->exceptionalDepositsTotal;
            
            
            $record->donations = $file->donations;
            for ($nDonationCount = 0; $nDonationCount < count($data->donationTypes); $nDonationCount++)
            {
                $record->donationTotal += $record->donations[$data->donationTypes[$nDonationCount]] * $data->donationTypes[$nDonationCount];
                $aLastRecordTotals->donationTotal += $record->donations[$data->donationTypes[$nDonationCount]] * $data->donationTypes[$nDonationCount];
                
                $aLastRecordTotals->donations[$data->donationTypes[$nDonationCount]] += $record->donations[$data->donationTypes[$nDonationCount]];
            }
            $record->incomeInclVat = $nIncomeProducts + $record->donationTotal + $record->exceptionalDepositsTotal;
            $record->incomeExclVat = $nIncomeProducts / 1.21 + $record->donationTotal + $record->exceptionalDepositsTotal;
            $aLastRecordTotals->incomeInclVat += $record->incomeInclVat;
            $aLastRecordTotals->incomeExclVat += $record->incomeExclVat;
            
            
            
            // --- expenses ---
            
            $record->transactioncosts = $revenue->expenses->transactioncosts;
            $aLastRecordTotals->transactioncosts += $record->transactioncosts;
            
            
            $record->donationRefunds = $file->donationRefunds;
            for ($nDonationRefundCount = 0; $nDonationRefundCount < count($data->donationRefundTypes); $nDonationRefundCount++)
            {
                $record->donationRefundsTotal += $record->donationRefunds[$data->donationRefundTypes[$nDonationRefundCount]] * $data->donationRefundTypes[$nDonationRefundCount];
                $aLastRecordTotals->donationRefundsTotal += $record->donationRefunds[$data->donationRefundTypes[$nDonationRefundCount]] * $data->donationRefundTypes[$nDonationRefundCount];
                
                $aLastRecordTotals->donationRefunds[$data->donationRefundTypes[$nDonationRefundCount]] += $record->donationRefunds[$data->donationRefundTypes[$nDonationRefundCount]];
            }
            
            $record->partialRefundsTotal = $revenue->expenses->partial_refunds;
            $aLastRecordTotals->partialRefundsTotal += $record->partialRefundsTotal;
            
            $record->expensesInclVat = $nRefundsProducts + $revenue->expenses->transactioncosts + $record->donationRefundsTotal + $record->partialRefundsTotal;
            // TODO - BTW van partial donations -> exceptional refunds los van partial refunds
            $record->expensesExclVat = $nRefundsProducts / 1.21 + $revenue->expenses->transactioncosts + $record->donationRefundsTotal + $record->partialRefundsTotal;
            $aLastRecordTotals->expensesInclVat += $record->expensesInclVat;
            $aLastRecordTotals->expensesExclVat += $record->expensesExclVat;
            
            
            
            // --- result ---
            
            $record->resultIncome = $record->incomeExclVat - $record->expensesExclVat;
            $record->resultVAT = $record->incomeProductsVat - $record->refundsProductsVat;
            $aLastRecordTotals->resultIncome += $record->resultIncome;
            $aLastRecordTotals->resultVAT += $record->resultVAT;
            
            
            // --- prepare for presentation
            
            $record->incomeProductsInclVat = number_format($record->incomeProductsInclVat, 2, '.', ',');
            $record->incomeProductsExclVat = number_format($record->incomeProductsExclVat, 2, '.', ',');
            $record->incomeProductsVat = number_format($record->incomeProductsVat, 2, '.', ',');
            
            $record->donationTotal = number_format($record->donationTotal, 2, ',', '.');
            $record->exceptionalDepositsTotal = number_format($record->exceptionalDepositsTotal, 2, ',', '.');
            
            $record->incomeInclVat = number_format($record->incomeInclVat, 2, ',', '.');
            $record->incomeExclVat = number_format($record->incomeExclVat, 2, ',', '.');
            
            
            
            $record->refundsProductsInclVat = number_format($record->refundsProductsInclVat, 2, ',', '.');
            $record->refundsProductsExclVat = number_format($record->refundsProductsExclVat, 2, ',', '.');
            $record->refundsProductsVat = number_format($record->refundsProductsVat, 2, ',', '.');
            
            $record->transactioncosts = number_format($record->transactioncosts, 2, ',', '.');
            $record->donationRefundsTotal = number_format($record->donationRefundsTotal, 2, ',', '.');
            $record->partialRefundsTotal = number_format($record->partialRefundsTotal, 2, ',', '.');
            
            $record->expensesInclVat = number_format($record->expensesInclVat, 2, ',', '.');
            $record->expensesExclVat = number_format($record->expensesExclVat, 2, ',', '.');
            
            $record->resultIncome = number_format($record->resultIncome, 2, ',', '.');
            $record->resultVAT = number_format($record->resultVAT, 2, ',', '.');
            
            // store
            $data->records[] = $record;
        }
        
        echo "<pre>";
        print_r($this->_aTransactions);
        echo "</pre>";
        
        
        
        
        $aMonths = array();
        
        
        foreach ($this->_aTransactions as $month => $members)
        {
            
            $nOffsetYear = intval(substr($month, 0, 4));
            $nOffsetMonth = intval(substr($month, 5, 2));
            
            
            for ($nMonthCount = 0; $nMonthCount < 12; $nMonthCount++)
            {
                
                $sYearMonth = date("Y.m", mktime(0, 0, 0, $nOffsetMonth + $nMonthCount, 1, $nOffsetYear));
                
                if (!isset($aMonths[$sYearMonth])) { $aMonths[$sYearMonth] = 0; }
                
                if ($nMonthCount === 0)
                {
                    $aMonths[$sYearMonth] += $members->month;
                }
                
                if ($nMonthCount < 3)
                {
                    $aMonths[$sYearMonth] += $members->gift3months;
                }
                
                $aMonths[$sYearMonth] += $members->year;
                $aMonths[$sYearMonth] += $members->gift12months;
            }   
            
        }
        
        echo "<pre>";
        print_r($aMonths);
        echo "</pre>";
        
        //die();
        
        
        
        
        
        // --- income ---
        
        $aLastRecordTotals->incomeProductsInclVat = number_format($aLastRecordTotals->incomeProductsInclVat, 2, ',', '.');
        $aLastRecordTotals->incomeProductsExclVat = number_format($aLastRecordTotals->incomeProductsExclVat, 2, ',', '.');
        $aLastRecordTotals->incomeProductsVat = number_format($aLastRecordTotals->incomeProductsVat, 2, ',', '.');
        
        $aLastRecordTotals->donationTotal = number_format($aLastRecordTotals->donationTotal, 2, ',', '.');
        $aLastRecordTotals->exceptionalDepositsTotal = number_format($aLastRecordTotals->exceptionalDepositsTotal, 2, ',', '.');
        
        $aLastRecordTotals->incomeInclVat = number_format($aLastRecordTotals->incomeInclVat, 2, ',', '.');
        $aLastRecordTotals->incomeExclVat = number_format($aLastRecordTotals->incomeExclVat, 2, ',', '.');
        
        
        // --- expenses ---
        
        $aLastRecordTotals->refundsProductsInclVat = number_format($aLastRecordTotals->refundsProductsInclVat, 2, ',', '.');
        $aLastRecordTotals->refundsProductsExclVat = number_format($aLastRecordTotals->refundsProductsExclVat, 2, ',', '.');
        $aLastRecordTotals->refundsProductsVat = number_format($aLastRecordTotals->refundsProductsVat, 2, ',', '.');
        
        $aLastRecordTotals->donationRefundsTotal = number_format($aLastRecordTotals->donationRefundsTotal, 2, ',', '.');
        $aLastRecordTotals->transactioncosts = number_format($aLastRecordTotals->transactioncosts, 2, ',', '.');
        $aLastRecordTotals->partialRefundsTotal = number_format($aLastRecordTotals->partialRefundsTotal, 2, ',', '.');
        
        $aLastRecordTotals->expensesInclVat = number_format($aLastRecordTotals->expensesInclVat, 2, ',', '.');
        $aLastRecordTotals->expensesExclVat = number_format($aLastRecordTotals->expensesExclVat, 2, ',', '.');
        
        
        // --- result ---
        
        $aLastRecordTotals->resultIncome = number_format($aLastRecordTotals->resultIncome, 2, ',', '.');
        $aLastRecordTotals->resultVAT = number_format($aLastRecordTotals->resultVAT, 2, ',', '.');
        
        
        
        //array_unshift($data->records, $aLastRecordTotals);
        $data->records[] = $aLastRecordTotals;
        
        
        
        
        // prepare for display (number_format etc)
        
        
        return $app['twig']->render(
            'ctfo.twig',
            array(
                'data' => $data,
                'filecount' => count($aFiles)
            )
        );
    }
    
    
    
    /**
     * Add a payment for a yearly membership
     * @param object $revenue
     * @param string $sDescription
     * @param float $nAmount
     */
    private function addYear($revenue, $sDescription, $nAmount, $sTransactionDate)
    {
        
        switch($sDescription)
        {
            case $this::UNSPECIFIED:
            case $this::YEAR:
            case $this::YEAR_DONATION:

                $revenue->year->new++;
                $revenue->income->year_new += $this::PRICE_YEAR;
                break;

            case $this::YEAR_RENEW:
            case $this::YEAR_RENEW_DONATION:

                $revenue->year->renew++;
                $revenue->income->year_renew += $this::PRICE_YEAR;
                break;
            
            DEFAULT:
                
                die('addYear - Unknown description');
        }
        
        
        // correct
        $nDonationAmount = floatval($nAmount - $this::PRICE_YEAR);
        
        // validate
        if ($nDonationAmount > 0)
        {
            // create key (without unnecessary decimals)
            if (!isset($revenue->year->donations[$nDonationAmount])) { $revenue->year->donations[$nDonationAmount] = 0; }
            
            // register
            $revenue->year->donations[$nDonationAmount]++;
            $revenue->income->donations += $nDonationAmount;
        }
        
        
        // register yearly membership
        $sTransactionMonth = substr($sTransactionDate, 6, 4).".".substr($sTransactionDate, 3, 2);
        if (!isset($this->_aTransactions[$sTransactionMonth])) $this->_aTransactions[$sTransactionMonth] = (object) array();
        $this->_aTransactions[$sTransactionMonth]->year++;
    }
    
    /**
     * Subtract a payment for a yearly membership
     * @param object $revenue
     * @param string $sDescription
     * @param float $nAmount
     */
    private function subtractYear($revenue, $sDescription, $nAmount)
    {
        
        switch($sDescription)
        {
            case $this::UNSPECIFIED:
            case $this::REFUND_UNSPECIFIED:
            case $this::REFUND_YEAR:
            case $this::REFUND_YEAR_DONATION:

                $revenue->year->refund_new++;
                $revenue->expenses->refund_year_new += $this::PRICE_YEAR;
                break;

            case $this::REFUND_YEAR_RENEW:
            case $this::REFUND_YEAR_RENEW_DONATION:

                $revenue->year->refund_renew++;
                $revenue->expenses->refund_year_renew += $this::PRICE_YEAR;
                break;
            
            DEFAULT:
                
                die('subtractYear - Unknown description');
        }
        
        
        // correct
        $nDonationAmount = floatval($nAmount - $this::PRICE_YEAR);
        
        // validate
        if ($nDonationAmount > 0)
        {
            // create key (without unnecessary decimals)
            if (!isset($revenue->year->donation_refunds[$nDonationAmount])) { $revenue->year->donation_refunds[$nDonationAmount] = 0; }
            
            // register
            $revenue->year->donation_refunds[$nDonationAmount]++;
            $revenue->expenses->donations += $nDonationAmount;
        }
    }
    
    
    /**
     * Add a payment for a monthly membership
     * @param object $revenue
     * @param string $sDescription
     * @param float $nAmount
     */
    private function addMonth($revenue, $sDescription, $nAmount, $sTransactionDate)
    {
        
        switch($sDescription)
        {
            case $this::MONTH:
            case $this::MONTH_DONATION:

                $revenue->month->new++;
                $revenue->income->month_new += $this::PRICE_MONTH;
                break;

            case $this::MONTH_RENEW:
            case $this::MONTH_RENEW_DONATION:  

                $revenue->month->renew++;
                $revenue->income->month_renew += $this::PRICE_MONTH;
                break;
            
            DEFAULT:
                
                die('addMonth - Unknown description');
        }

        
        // correct
        $nDonationAmount = floatval($nAmount - $this::PRICE_MONTH);
        
        // validate
        if ($nDonationAmount > 0)
        {
            // create key (without unnecessary decimals)
            if (!isset($revenue->month->donations[$nDonationAmount])) { $revenue->month->donations[$nDonationAmount] = 0; }
            
            // register
            $revenue->month->donations[$nDonationAmount]++;
            $revenue->income->donations += $nDonationAmount;
        }
        
        
        // register monthly membership
        $sTransactionMonth = substr($sTransactionDate, 6, 4).".".substr($sTransactionDate, 3, 2);
        if (!isset($this->_aTransactions[$sTransactionMonth])) $this->_aTransactions[$sTransactionMonth] = (object) array();
        $this->_aTransactions[$sTransactionMonth]->month++;
    }
    
    /**
     * Subtract a payment for a monthly membership
     * @param object $revenue
     * @param string $sDescription
     * @param float $nAmount
     */
    private function subtractMonth($revenue, $sDescription, $nAmount)
    {
        
        switch($sDescription)
        {
            case $this::REFUND_MONTH:
            case $this::REFUND_MONTH_DONATION:

                $revenue->month->refund_new++;
                $revenue->expenses->refund_month_new += $this::PRICE_MONTH;
                break;

            case $this::REFUND_MONTH_RENEW:
            case $this::REFUND_MONTH_RENEW_DONATION:

                $revenue->month->refund_renew++;
                $revenue->expenses->refund_month_renew += $this::PRICE_MONTH;
                break;
            
            DEFAULT:
                
                die('subtractMonth - Unknown description');
        }

        
        // correct
        $nDonationAmount = floatval($nAmount - $this::PRICE_MONTH);
        
        // validate
        if ($nDonationAmount > 0)
        {
            // create key (without unnecessary decimals)
            if (!isset($revenue->month->donation_refunds[$nDonationAmount])) { $revenue->month->donation_refunds[$nDonationAmount] = 0; }
            
            // register
            $revenue->month->donation_refunds[$nDonationAmount]++;
            $revenue->expenses->donations += $nDonationAmount;
        }
    }
    
    /**
     * Add a payment for a 3 month gift
     * @param object $revenue
     */
    private function addGift3Months($revenue, $sTransactionDate)
    {
        
        // register
        $revenue->gift_3months->amount++;
        $revenue->income->gift_3months += $this::PRICE_GIFT_3MONTHS;
        
        
        // register 3 monthly gift
        $sTransactionMonth = substr($sTransactionDate, 6, 4).".".substr($sTransactionDate, 3, 2);
        if (!isset($this->_aTransactions[$sTransactionMonth])) $this->_aTransactions[$sTransactionMonth] = (object) array();
        $this->_aTransactions[$sTransactionMonth]->gift3months++;
    } 
    
    /**
     * Subtract a payment for a 3 month gift
     * @param object $revenue
     */
    private function subtractGift3Months($revenue)
    {
        
        // register
        $revenue->gift_3months->refunds++;
        $revenue->expenses->gift_3months += $this::PRICE_GIFT_3MONTHS;
    } 
    
    /**
     * Add a payment for a 12 month gift
     * @param object $revenue
     */
    private function addGift12Months($revenue, $sTransactionDate)
    {
        
        // register
        $revenue->gift_12months->amount++;
        $revenue->income->gift_3months += $this::PRICE_GIFT_12MONTHS;
        
        
        // register 12 monthly gift
        $sTransactionMonth = substr($sTransactionDate, 6, 4).".".substr($sTransactionDate, 3, 2);
        if (!isset($this->_aTransactions[$sTransactionMonth])) $this->_aTransactions[$sTransactionMonth] = (object) array();
        $this->_aTransactions[$sTransactionMonth]->gift12months++;
    }
    
    /**
     * Subtract a payment for a 12 month gift
     * @param object $revenue
     */
    private function subtractGift12Months($revenue)
    {
        
        // register
        $revenue->gift_12months->refunds++;
        $revenue->expenses->gift_12months += $this::PRICE_GIFT_12MONTHS;
    } 
    
}
