<?php

class onSubscriptionsCronDeleteExpiredUnconfirmed extends cmsAction {

    public function run(){

        $this->model->filterDateOlder('date_pub', $this->options['verify_exp'], 'HOUR')->
                filterIsNull('is_confirmed')->deleteFiltered('subscriptions_bind');

        return true;

    }

}
