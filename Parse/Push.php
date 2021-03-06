<?php

namespace Gpaton\ParseBundle\Parse;

use Parse\ParseClient;
use Parse\ParseException;
use Parse\ParsePush;
use Parse\ParseQuery;

class Push extends Parse
{
    protected $appId;
    protected $restKey;
    protected $masterKey;

    /**
     * Initialize Push with needed Parse keys
     *
     * @param $appId
     * @param $restKey
     * @param $masterKey
     */
    public function __construct($appId, $restKey, $masterKey)
    {
        $this->appId = $appId;
        $this->restKey = $restKey;
        $this->masterKey = $masterKey;

        ParseClient::initialize($appId, $restKey, $masterKey);
    }

    /**
     * @param $data
     * @param null|array $channels
     * @param null|ParseQuery $where
     * @param null|\DateTime $pushTime
     * @return mixed
     * @throws ParseException
     * @throws \Exception
     */
    public function send($data, $channels = null, ParseQuery $where = null, \DateTime $pushTime = null)
    {
        $params['data'] = $data;

        /*
         * Check that $channels is a string or an array of strings
         * Check channel strings (no space)
         */
        if (null !== $channels) {
            if (!is_array($channels)) {
                throw new ParseException('$channels must be an array of strings');
            } else {
                $params['channels'] = $channels;
            }
        }

        if (null !== $where) {
            $params['where'] = $where;
        }

        if (null !== $pushTime) {
            $params['push_time'] = $pushTime;
            $params['local_time'] = new \DateTime();
        }

        return ParsePush::send($params);
    }
}
