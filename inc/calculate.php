<?php
/*	Calculate function.
 *	This function takes the values from the form and
 *	performs calculations to determine the payment amount.
 */
function calculate( $values ) {
	
	// Make the array values easier to use.
	$ta = $values['ta'];
	$dp = $values['dp'];
	$ir = $values['ir'];
	$am = $values['am'];
	$pp = $values['pp'];
	
	// Calculate the total amount of the loan.
	$loan = $ta - $dp;

	// Calculate the number of payments.
	$nPayments = $am * $pp;

	// Canadian mortgage interest rates are compounded semi-annually.
	// Convert the interest rate to a decimal.
	$ir = $ir/100;
	// Semi-annual interest rate:
	$ir = ( $ir/2 ) * ( 1 + ( 1 + ( $ir/2 ) ) );
	// The effective interest rate depends on the payment period (monthly, bi-weekly, or weekly).
	// This is reverse compounded.
	$ir = pow( ( $ir + 1 ), ( 1/($pp) ) ) - 1;

	// Calculate the total interest rate for the duration of the loan.
	$tir = pow( ( $ir + 1 ), $nPayments );

	// Calculate the payments.
	$payment = $loan * ( ( $ir * $tir ) / ( $tir - 1 ) );

	// Set the result for output.
	$result = round( $payment, 2 );
	
	return $result;
	
}