<?php namespace App\Http\Api\Core\Models;


class ExceptionModel {

    /**
     * Unique identifier for this particular occurrence of the problem.
     */
    protected $id;

    /**
     * a links object containing:
     *  - about: a link that leads to a human-readable description of this particular occurrence of the problem.
     */
    protected $links_about;

    /**
     * a links object containing:
     *  -  type: array of links where is possible to find an human-readable explanation of the general error.
     */
    protected $links_type;

    /**
     * HTTP status code applicable to this problem, expressed as a string value.
     *
     */
    protected $status;

    /**
     * Application-specific error code, expressed as a string value
     *
     */
    protected $code;

    /**
     * short, human-readable summary of the problem that SHOULD NOT change from occurrence to occurrence of the problem
     *
     */
    protected $title;

    /**
     * human-readable explanation specific to this occurrence of the problem
     *
     */
    protected $detail;

    /**
     * object containing references to the source of the error.
     * - pointer: pointer to the value in the request document that caused the error.
     */
    protected $source_pointer;

    /**
     * object containing references to the source of the error.
     * - parameter: string indicating the URI query parameter that caused the error.
     */
    protected $source_parameter;

    /**
     * Meta Object containing non-standard information about the error
     */
    protected $meta;

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLinksAbout() {
        return $this->links_about;
    }

    /**
     * @return mixed
     */
    public function getLinksType() {
        return $this->links_type;
    }

    /**
     * @return mixed
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getDetail() {
        return $this->detail;
    }

    /**
     * @return mixed
     */
    public function getSourcePointer() {
        return $this->source_pointer;
    }

    /**
     * @return mixed
     */
    public function getSourceParameter() {
        return $this->source_parameter;
    }

    /**
     * @return mixed
     */
    public function getMeta() {
        return $this->meta;
    }

    /**
     * @param mixed $id
     * @return ExceptionModel
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * @param mixed $links_about
     * @return ExceptionModel
     */
    public function setLinksAbout($links_about) {
        $this->links_about = $links_about;
        return $this;
    }

    /**
     * @param mixed $links_type
     * @return ExceptionModel
     */
    public function setLinksType($links_type) {
        $this->links_type = $links_type;
        return $this;
    }

    /**
     * @param mixed $status
     * @return ExceptionModel
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * @param mixed $code
     * @return ExceptionModel
     */
    public function setCode($code) {
        $this->code = $code;
        return $this;
    }

    /**
     * @param mixed $title
     * @return ExceptionModel
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * @param mixed $detail
     * @return ExceptionModel
     */
    public function setDetail($detail) {
        $this->detail = $detail;
        return $this;
    }

    /**
     * @param mixed $source_pointer
     * @return ExceptionModel
     */
    public function setSourcePointer($source_pointer) {
        $this->source_pointer = $source_pointer;
        return $this;
    }

    /**
     * @param mixed $source_parameter
     * @return ExceptionModel
     */
    public function setSourceParameter($source_parameter) {
        $this->source_parameter = $source_parameter;
        return $this;
    }

    /**
     * @param mixed $meta
     * @return ExceptionModel
     */
    public function setMeta($meta) {
        $this->meta = $meta;
        return $this;
    }


    public function to_array() {

        $repr = [];

        if(!empty($id))
            $repr["id"] = $this->id;

        if(!empty($this->links_about)||!empty($this->links_type)){
            $repr["links"] = [];
            if(!empty($this->links_about))
                $repr["links"]["about"] = $this->links_about;
            if(!empty($this->type))
                $repr["links"]["type"] = $this->links_type;
        }

        if(!empty($this->status))
            $repr["status"] = $this->status;

        if(!empty($this->code))
            $repr["code"] = $this->code;

        if(!empty($this->title))
            $repr["title"] = $this->title;

        if(!empty($this->detail))
            $repr["detail"] = $this->detail;

        if(!empty($this->source_pointer)||!empty($this->source_parameter)){
            $repr["source"] = [];
            if(!empty($this->source_pointer))
                $repr["source"]["pointer"] = $this->source_pointer;
            if(!empty($this->source_parameter))
                $repr["source"]["parameter"] = $this->source_parameter;
        }

        if(!empty($this->meta))
            $repr["meta"] = $this->meta;

        return $repr;
    }

}
