<?php


namespace ellera\commerce\klarna\models\forms;


class BaseSessionForm extends BasePaymentForm
{
    /**
     * @var array
     */
    public $merchant_session_urls;

    /**
     * Generate Create Session Body
     *
     * @param string $payment_session_url
     * @return array
     */
    public function generateCreateSessionRequestBody(string $payment_session_url)
    {
        $body = [
            'payment_session_url' => $payment_session_url,
            'merchant_urls' => $this->merchant_session_urls,
        ];
        if(is_array($this->gateway->methods) && !empty($this->gateway->methods))
        {
            if(count($this->gateway->methods) == 1) $body['options']['payment_method_category'] = $this->gateway->methods[0];
            else $body['options']['payment_method_categories'] = $this->gateway->methods;
        }
        /** @var $this->gateway Hosted */
        if($this->gateway->getLogoUrl()) $body['options']['logo'] = $this->gateway->getLogoUrl();
        if($this->gateway->getBackgroundUrl()) $body['options']['background_images'] = $this->gateway->getBackgroundUrl();
        /*
        if(is_array($this->gateway->methods) && !empty($this->gateway->methods))
        {
            if(count($this->gateway->methods) == 1) $body['options']['payment_method_category'] = $this->gateway->methods[0];
            elseif(count($this->gateway->methods) > 1) $body['options']['payment_method_categories'] = $this->gateway->methods;
        }
        */
        return $body;
    }
}