<?php
class Zenfox_Transaction_Factory
{
	public static function getInstance($gateway)
	{
		switch($gateway)
		{
			case 'TECHPROCESS':
				return new Zenfox_Transaction_Gateway_Techprocess();
			case 'CITRUSPAY':
				return new Zenfox_Transaction_Gateway_Citruspay();
			case 'MOBIKWIK':
				return new Zenfox_Transaction_Gateway_Mobikwik();
			case 'EBS':
				return new Zenfox_Transaction_Gateway_EBS();
		}
	}	
}