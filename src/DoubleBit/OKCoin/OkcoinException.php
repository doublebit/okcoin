<?php

namespace DoubleBit\OKCoin;

class OkcoinException extends \Exception
{

    protected $message = '';
    protected $code = 0;
    
    
    protected $codes = [
        10000 => 'Required field, can not be null',
        10001 => 'Request frequency too high',
        10002 => 'System error',
        10003 => 'Not in reqest list, please try again later',
        10004 => 'IP not allowed to access the resource',
        10005 => '\'secretKey\' does not exist',
        10006 => '\'partner\' does not exist',
        10007 => 'Signature does not match',
        10008 => 'Illegal parameter',
        10009 => 'Order does not exist',
        10010 => 'Insufficient funds',
        10011 => 'Amount too low',
        10012 => 'Only btc_usd ltc_usd supported',
        10013 => 'Only support https request',
        10014 => 'Order price must be between 0 and 1,000,000',
        10015 => 'Order price differs from current market price too much',
        10016 => 'Insufficient coins balance',
        10017 => 'API authorization error',
        10018 => 'borrow amount less than lower limit [usd:100,btc:0.1,ltc:1]',
        10019 => 'loan agreement not checked',
        10020 => 'rate cannot exceed 1%',
        10021 => 'rate cannot less than 0.01%',
        10023 => 'fail to get latest ticker',
        10024 => 'balance not sufficient',
        10025 => 'quota is full, cannot borrow temporarily',
        10026 => 'Loan (including reserved loan) and margin cannot be withdrawn',
        10027 => 'Cannot withdraw within 24 hrs of authentication information modification',
        10028 => 'Withdrawal amount exceeds daily limit',
        10029 => 'Account has unpaid loan, please cancel/pay off the loan before withdraw',
        10031 => 'Deposits can only be withdrawn after 6 confirmations',
        10032 => 'Please enabled phone/google authenticator',
        10033 => 'Fee higher than maximum network transaction fee',
        10034 => 'Fee lower than minimum network transaction fee',
        10035 => 'Insufficient BTC/LTC',
        10036 => 'Withdrawal amount too low',
        10037 => 'Trade password not set',
        10040 => 'Withdrawal cancellation fails',
        10041 => 'Withdrawal address not approved',
        10042 => 'Admin password error',
        10043 => 'Account equity error, withdrawal failure',
        10044 => 'fail to cancel borrowing order',
        10047 => 'this function is disabled for sub-account',
        10048 => 'withdrawal information does not exist',
        10049 => 'User can not have more than 50 unfilled small orders (amount<0.5BTC)',
        10050 => 'can\'t cancel more than once',
        10100 => 'User account frozen',
        10101 => 'order type is wrong',
        10102 => 'incorrect ID',
        10103 => 'the private otc order\'s key incorrect',
        10216 => 'Non-available API',
        20001 => 'User does not exist',
        20002 => 'Account frozen',
        20003 => 'Account frozen due to liquidation',
        20004 => 'Contract account frozen',
        20005 => 'User contract account does not exist',
        20006 => 'Required field missing',
        20007 => 'Illegal parameter',
        20008 => 'Contract account balance is too low',
        20009 => 'Contract status error',
        20010 => 'Risk rate ratio does not exist',
        20011 => 'Risk rate lower than 90% before opening position',
        20012 => 'Risk rate lower than 90% after opening position',
        20013 => 'Temporally no counter party price',
        20014 => 'System error',
        20015 => 'Order does not exist',
        20016 => 'Close amount bigger than your open positions',
        20017 => 'Not authorized/illegal operation',
        20018 => 'Order price cannot be more than 103% or less than 97% of the previous minute price',
        20019 => 'IP restricted from accessing the resource',
        20020 => 'secretKey does not exist',
        20021 => 'Index information does not exist',
        20022 => 'Wrong API interface (Cross margin mode shall call cross margin API, fixed margin mode shall call fixed margin API)',
        20023 => 'Account in fixed-margin mode',
        20024 => 'Signature does not match',
        20025 => 'Leverage rate error',
        20026 => 'API Permission Error',
        20027 => 'no transaction record',
        20028 => 'no such contract',
        20029 => 'Amount is large than available funds',
        20030 => 'Account still has debts',
        20038 => 'Due to regulation, this function is not available in the country/region your currently reside in.',
        20049 => 'Request frequency too high',
        10060 => 'Your withdrawal has been locked. Please contact support.',
        10104 => 'Suspicious activities detected. OTC Trading is temporarily disabled!',
        503 => 'Too many requests (HTTP)',
        404 => 'Endpoint not found (HTTP)'
    ];

    public function __construct($message = null, $code = 0, \Exception $previous = null) {
        if (isset($this->codes[$code])) {
            $message = $this->codes[$code];
        } elseif (is_null($message)) {
            $message = 'Unknown error! Code ' . $code;
        }
        parent::__construct($message, $code, $previous);
    }

}