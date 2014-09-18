<?php
/*	This page displays the mortgage calculator form.
 */

// Set some variables.
$errors = array();
$values = array();
$inputs = array();
$result = null;
$summary = null;

// Include the Input and Select classes.
require( 'inc/Input.php' );
require( 'inc/Select.php' );
	
// Create the inputs.
$inputs['ta'] = new Input( 'Total Amount', 'lidd_rmc_total_amount', '$' );
$inputs['dp'] = new Input( 'Down Payment', 'lidd_rmc_down_payment', '$' );
$inputs['ir'] = new Input( 'Interest Rate', 'lidd_rmc_interest_rate', '%' );
$inputs['am'] = new Input( 'Amortization Period', 'lidd_rmc_amortization', 'years' );
$inputs['pp'] = new Select( 'Payment Period', 'lidd_rmc_payment_period', array(
	'12' => 'Monthly',
	'26' => 'Bi-Weekly',
	'52' => 'Weekly'
	)
);

// Check for submission and perform validation.
if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset( $_POST['lidd_rmc_submit'] ) ) {
	
	// Include the validation routines.
	include( 'inc/validate.php' );
	list( $values, $errors ) = validate( $_POST );
	
	// Assign the Input values.
	foreach ( $values as $k => $v ) {
		$inputs[$k]->setValue($v);
	}
	
	// If there are no errors, include the calculation process.
	if ( empty( $errors ) ) {
		include( 'inc/calculate.php' );
		$result = calculate( $values );
	} else {
		// Send the errors to the respective Inputs.
		foreach ( $errors as $k => $v ) {
			$inputs[$k]->setError($v);
		}
	}
	
}

// Output the form.

?>

	<form action="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" id="lidd_rmc_form" class="lidd_rmc_form" method="post">
	
<?php
	
$inputs['ta']->getInput();
$inputs['dp']->getInput();
$inputs['ir']->getInput();
$inputs['am']->getInput();
$inputs['pp']->getInput();

// Create the submit button and close the form...
?>
	<p><input type="submit" name="lidd_rmc_submit" id="lidd_rmc_submit" value="Calculate" /></p>
</form>

<?php

echo '
<div id="lidd_rmc_details"';
echo ( !$result ) ? ' style="display: none;"' : '';
echo '>
	<div id="lidd_rmc_results"><p>Payments: <b class="lidd-b">$' . $result . '</b></p></div>
	<img id="lidd_rmc_inspector" src="http://sandbox.dev/JS/mortgageCalculator/img/icon_inspector.png" alt="Details">
	<div id="lidd_rmc_summary"';
echo ( !$summary ) ? ' style="display: none;"' : '';
echo '>' . $summary . '</div>
</div>
';