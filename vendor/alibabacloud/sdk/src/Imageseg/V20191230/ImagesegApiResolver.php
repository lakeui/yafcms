<?php

namespace AlibabaCloud\Imageseg\V20191230;

use AlibabaCloud\Client\Resolver\ApiResolver;

/**
 * @method ParseFace parseFace(array $options = [])
 * @method RefineMask refineMask(array $options = [])
 * @method SegmentBody segmentBody(array $options = [])
 * @method SegmentCommodity segmentCommodity(array $options = [])
 * @method SegmentCommonImage segmentCommonImage(array $options = [])
 * @method SegmentFace segmentFace(array $options = [])
 * @method SegmentFurniture segmentFurniture(array $options = [])
 * @method SegmentHair segmentHair(array $options = [])
 * @method SegmentHead segmentHead(array $options = [])
 * @method SegmentVehicle segmentVehicle(array $options = [])
 */
class ImagesegApiResolver extends ApiResolver
{
}

class Rpc extends \AlibabaCloud\Client\Resolver\Rpc
{
    /** @var string */
    public $product = 'imageseg';

    /** @var string */
    public $version = '2019-12-30';

    /** @var string */
    public $method = 'POST';

    /** @var string */
    public $serviceCode = 'imageseg';
}

/**
 * @method string getImageURL()
 * @method $this withImageURL($value)
 */
class ParseFace extends Rpc
{
}

/**
 * @method string getMaskImageURL()
 * @method string getImageURL()
 */
class RefineMask extends Rpc
{

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withMaskImageURL($value)
    {
        $this->data['MaskImageURL'] = $value;
        $this->options['form_params']['MaskImageURL'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withImageURL($value)
    {
        $this->data['ImageURL'] = $value;
        $this->options['form_params']['ImageURL'] = $value;

        return $this;
    }
}

/**
 * @method string getImageURL()
 * @method $this withImageURL($value)
 */
class SegmentBody extends Rpc
{
}

/**
 * @method string getImageURL()
 * @method $this withImageURL($value)
 */
class SegmentCommodity extends Rpc
{
}

/**
 * @method string getImageURL()
 * @method $this withImageURL($value)
 */
class SegmentCommonImage extends Rpc
{
}

/**
 * @method string getImageURL()
 * @method $this withImageURL($value)
 */
class SegmentFace extends Rpc
{
}

/**
 * @method string getImageURL()
 */
class SegmentFurniture extends Rpc
{

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withImageURL($value)
    {
        $this->data['ImageURL'] = $value;
        $this->options['form_params']['ImageURL'] = $value;

        return $this;
    }
}

/**
 * @method string getImageURL()
 * @method $this withImageURL($value)
 */
class SegmentHair extends Rpc
{
}

/**
 * @method string getImageURL()
 * @method $this withImageURL($value)
 */
class SegmentHead extends Rpc
{
}

/**
 * @method string getImageURL()
 */
class SegmentVehicle extends Rpc
{

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withImageURL($value)
    {
        $this->data['ImageURL'] = $value;
        $this->options['form_params']['ImageURL'] = $value;

        return $this;
    }
}
