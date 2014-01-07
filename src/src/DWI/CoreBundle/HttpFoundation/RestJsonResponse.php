<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\CoreBundle\HttpFoundation;

use Symfony\Component\HttpFoundation\JsonResponse;

class RestJsonResponse extends JsonResponse
{
    const GENERIC_BAD_AUTH    = 'Bad authentication.';
    const GENERIC_BAD_REQUEST = 'Bad request.';
    const BAD_REQUEST_METHOD  = 'Bad request method.';
    const ENTITY_NOT_FOUND    = 'Entity not found.';


    /**
     * @var \ArrayObject
     */
    private $response;


    /**
     * Constructor
     *
     * @param \ArrayObject|null  $data
     * @param integer            $status
     * @param array              $headers
     */
    public function __construct($data = null, $status = 200, $headers = array())
    {
        parent::__construct($data, $status, $headers);

        $this->response = new \ArrayObject();
    }


    /**
     * Build REST response
     *
     * @return RestJsonResponse
     */
    public function buildResponse()
    {
        $this->setData($this->response);

        return $this;
    }


    /**
     * Add error
     *
     * @param  String $message
     * @return RestJsonResponse
     */
    public function addError($message)
    {
        $this->response['errors'][] = array(
            'message' => $message,
        );

        return $this->buildResponse();
    }


    /**
     * Get errors
     *
     * @return \ArrayObject
     */
    public function getErrors()
    {
        return $this->response['errors'];
    }


    /**
     * Clear errors
     *
     * @return RestJsonResponse
     */
    public function clearErrors()
    {
        $this->response['errors'] = array();

        return $this;
    }
}
