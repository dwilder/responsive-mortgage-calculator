<?php
/*	This functions runs validation on each of the submitted values.
 *	It expects total amount, interest rate, amortization and payment period.
 *	Down payment is optional.
 */
function validate( $input = array() ) {
	
	// Set return arrays.
	$values = array();
	$errors = array();
	
	// Check the total amount.
	if ( isset( $input['lidd_rmc_total_amount'] ) && is_numeric( $input['lidd_rmc_total_amount'] ) ) {
		$values['ta'] = abs( $input['lidd_rmc_total_amount'] );
	} else {
		$values['ta'] = null;
		$errors['ta'] = 'Please enter the total cost.';
	}
	
	// Check for a down payment. This is optional, so two stage validation.
	// It must be less than the total amount.
	if ( isset( $input['lidd_rmc_down_payment'] ) && !empty( $input['lidd_rmc_down_payment'] ) ) {
		if ( is_numeric( $input['lidd_rmc_down_payment'] ) && abs( $input['lidd_rmc_down_payment'] < $values['ta'] ) ) {
			$values['dp'] = abs( $input['lidd_rmc_down_payment'] );
		} else {
			$values['dp'] = null;
			$errors['dp'] = 'Please enter a valid down payment amount or leave blank.';
		}
	} else {
		$values['dp'] = null;
	}
	
	// Check the interest rate. This needs to be between 0 and 100.
	if ( isset( $input['lidd_rmc_interest_rate'] ) && is_numeric( $input['lidd_rmc_interest_rate'] ) && $input['lidd_rmc_interest_rate'] < 100 && $input['lidd_rmc_interest_rate'] > 0 ) {
		$values['ir'] = abs( $input['lidd_rmc_interest_rate'] );
	} else {
		$values['ir'] = null;
		$errors['ir'] = 'Please enter a valid interest rate.';
	}
	
	// Check for the payment period, just in case.
	if ( isset( $input['lidd_rmc_payment_period'] ) ) {
		switch( $input['lidd_rmc_payment_period'] ) {
			case '52':
				$values['pp'] = 52;
				break;
			case '26':
				$values['pp'] = 26;
				break;
			default:
				$values['pp'] = 12;
				break;
		}
	}
	
	// Check for the amortization period. This is between 0 and 50 years.
	// It also needs to fit nicely with the payment periods.
	if ( isset( $input['lidd_rmc_amortization'] ) && is_numeric( $input['lidd_rmc_amortization'] ) && $input['lidd_rmc_amortization'] < 100 && $input['lidd_rmc_amortization'] > 0 ) {
		$values['am'] = abs( $input['lidd_rmc_amortization'] );
		$values['am'] = abs( ceil( ($values['am'])*$values['pp'] ) / $values['pp'] );
	} else {
		$values['am'] = null;
		$errors['am'] = 'Please enter a valid amortization period.';
	}
	
	// Return the arrays.
	return array( $values, $errors );
	
}
?>