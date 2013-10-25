<?php 
function format_address($fields, $br=false)
{
	if(empty($fields))
	{
		return ;
	}
	
	// Default format
	$default = "{firstname} {lastname}\n{company}\n{address_1}\n{address_2}\n{city}, {zone} {postcode}\n{country}";
	
	// Fetch country record to determine which format to use
	$CI = &get_instance();
	$CI->load->model('location_model');
	$c_data = $CI->location_model->get_country($fields['country_id']);
	
	if(empty($c_data->address_format))
	{
		$formatted	= $default;
	} else {
		$formatted	= $c_data->address_format;
	}

	$formatted		= str_replace('{firstname}', $fields['firstname'], $formatted);
	$formatted		= str_replace('{lastname}',  $fields['lastname'], $formatted);
	$formatted		= str_replace('{company}',  $fields['company'], $formatted);
	
	$formatted		= str_replace('{address_1}', $fields['address1'], $formatted);
	$formatted		= str_replace('{address_2}', $fields['address2'], $formatted);
	$formatted		= str_replace('{city}', $fields['city'], $formatted);
	$formatted		= str_replace('{zone}', $fields['zone'], $formatted);
	$formatted		= str_replace('{postcode}', $fields['zip'], $formatted);
	$formatted		= str_replace('{country}', $fields['country'], $formatted);
	
	// remove any extra new lines resulting from blank company or address line
	$formatted		= preg_replace('`[\r\n]+`',"\n",$formatted);
	if($br)
	{
		$formatted	= nl2br($formatted);
	}
	return $formatted;
	
}

function format_currency($value, $symbol=true)
{

	if(!is_numeric($value))
	{
		return;
	}
	
	$CI = &get_instance();
	
	if($value < 0 )
	{
		$neg = '- ';
	} else {
		$neg = '';
	}
	
	if($symbol)
	{
		if(true == $CI->config->item('currency_format_india'))
		{
			$formatted = format_currency_india($value);
		} 
		else 
		{
			$formatted	= number_format(abs($value), 2, $CI->config->item('currency_decimal'), $CI->config->item('currency_thousands_separator'));
		}
		if($CI->config->item('currency_symbol_side') == 'left')
		{
			$formatted	= $neg.$CI->config->item('currency_symbol').$formatted;
		}
		else
		{
			$formatted	= $neg.$formatted.$CI->config->item('currency_symbol');
		}
	}
	else
	{
		//traditional number formatting
		$formatted	= number_format(abs($value), 2, '.', ',');
	}
	
	return $formatted;
}

function format_currency_india($value)
{
	
	if($value == 0)
	{
		return '0.00';
	}
	
	$value = abs($value)* 100;
	$explrestunits = "";
	if (strlen($value) > 5) {
		$lastthree = substr($value, strlen($value) - 5, strlen($value));
		$restunits = substr($value, 0, strlen($value) - 5); // extracts the last three digits
		$restunits = (strlen($restunits) % 2 == 1) ? "0" . $restunits : $restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
		$expunit = str_split($restunits, 2);
		for ($i = 0; $i < sizeof($expunit); $i++) {
			// creates each of the 2's group and adds a comma to the end
			if ($i == 0) {
				$explrestunits .= (int) $expunit[$i] . ","; // if is first value , convert into integer
			}
			else 
			{
				$explrestunits .= $expunit[$i] . ",";
			}
		}
		$thecash = $explrestunits . $lastthree;
	}
	else
	{
		$thecash = $value;
	}
	$lastthree = substr($thecash, strlen($thecash) - 2, strlen($thecash));
	$restunits = substr($thecash, 0, strlen($thecash) - 2);

	return $restunits . '.' . $lastthree; // writes the final format where $currency is the currency symbol.

}