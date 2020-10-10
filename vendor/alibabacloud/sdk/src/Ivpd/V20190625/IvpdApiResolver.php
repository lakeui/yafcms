<?php

namespace AlibabaCloud\Ivpd\V20190625;

use AlibabaCloud\Client\Resolver\ApiResolver;

/**
 * @method ChangeImageSize changeImageSize(array $options = [])
 * @method CreateSegmentBodyJob createSegmentBodyJob(array $options = [])
 * @method DetectImageElements detectImageElements(array $options = [])
 * @method ExtendImageStyle extendImageStyle(array $options = [])
 * @method GetJobResult getJobResult(array $options = [])
 * @method GetJobStatus getJobStatus(array $options = [])
 * @method GetRenderResult getRenderResult(array $options = [])
 * @method ListPackageDesignModelTypes listPackageDesignModelTypes(array $options = [])
 * @method MakeSuperResolutionImage makeSuperResolutionImage(array $options = [])
 * @method PreviewModelForPackageDesign previewModelForPackageDesign(array $options = [])
 * @method RecognizeImageColor recognizeImageColor(array $options = [])
 * @method RecognizeImageStyle recognizeImageStyle(array $options = [])
 * @method RecolorImage recolorImage(array $options = [])
 * @method RenderImageForPackageDesign renderImageForPackageDesign(array $options = [])
 * @method SegmentBody segmentBody(array $options = [])
 * @method SegmentImage segmentImage(array $options = [])
 */
class IvpdApiResolver extends ApiResolver
{
}

class Rpc extends \AlibabaCloud\Client\Resolver\Rpc
{
    /** @var string */
    public $product = 'ivpd';

    /** @var string */
    public $version = '2019-06-25';

    /** @var string */
    public $method = 'POST';
}

/**
 * @method string getUrl()
 * @method string getWidth()
 * @method string getHeight()
 */
class ChangeImageSize extends Rpc
{

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withUrl($value)
    {
        $this->data['Url'] = $value;
        $this->options['form_params']['Url'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withWidth($value)
    {
        $this->data['Width'] = $value;
        $this->options['form_params']['Width'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withHeight($value)
    {
        $this->data['Height'] = $value;
        $this->options['form_params']['Height'] = $value;

        return $this;
    }
}

/**
 * @method array getDataList()
 * @method string getAsync()
 * @method string getJobId()
 * @method string getTimeToLive()
 */
class CreateSegmentBodyJob extends Rpc
{

    /**
     * @param array $dataList
     *
     * @return $this
     */
	public function withDataList(array $dataList)
	{
	    $this->data['DataList'] = $dataList;
		foreach ($dataList as $depth1 => $depth1Value) {
			if(isset($depth1Value['DataId'])){
				$this->options['form_params']['DataList.' . ($depth1 + 1) . '.DataId'] = $depth1Value['DataId'];
			}
			if(isset($depth1Value['ImageUrl'])){
				$this->options['form_params']['DataList.' . ($depth1 + 1) . '.ImageUrl'] = $depth1Value['ImageUrl'];
			}
		}

		return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAsync($value)
    {
        $this->data['Async'] = $value;
        $this->options['form_params']['Async'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withJobId($value)
    {
        $this->data['JobId'] = $value;
        $this->options['form_params']['JobId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withTimeToLive($value)
    {
        $this->data['TimeToLive'] = $value;
        $this->options['form_params']['TimeToLive'] = $value;

        return $this;
    }
}

/**
 * @method string getUrl()
 */
class DetectImageElements extends Rpc
{

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withUrl($value)
    {
        $this->data['Url'] = $value;
        $this->options['form_params']['Url'] = $value;

        return $this;
    }
}

/**
 * @method string getMajorUrl()
 * @method string getStyleUrl()
 */
class ExtendImageStyle extends Rpc
{

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withMajorUrl($value)
    {
        $this->data['MajorUrl'] = $value;
        $this->options['form_params']['MajorUrl'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withStyleUrl($value)
    {
        $this->data['StyleUrl'] = $value;
        $this->options['form_params']['StyleUrl'] = $value;

        return $this;
    }
}

/**
 * @method string getJobId()
 */
class GetJobResult extends Rpc
{

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withJobId($value)
    {
        $this->data['JobId'] = $value;
        $this->options['form_params']['JobId'] = $value;

        return $this;
    }
}

/**
 * @method string getJobId()
 */
class GetJobStatus extends Rpc
{

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withJobId($value)
    {
        $this->data['JobId'] = $value;
        $this->options['form_params']['JobId'] = $value;

        return $this;
    }
}

/**
 * @method string getJobId()
 */
class GetRenderResult extends Rpc
{

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withJobId($value)
    {
        $this->data['JobId'] = $value;
        $this->options['form_params']['JobId'] = $value;

        return $this;
    }
}

class ListPackageDesignModelTypes extends Rpc
{
}

/**
 * @method string getUrl()
 */
class MakeSuperResolutionImage extends Rpc
{

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withUrl($value)
    {
        $this->data['Url'] = $value;
        $this->options['form_params']['Url'] = $value;

        return $this;
    }
}

/**
 * @method string getMaterialName()
 * @method array getElementList()
 * @method string getDataId()
 * @method string getMaterialType()
 * @method string getModelType()
 * @method string getCategory()
 */
class PreviewModelForPackageDesign extends Rpc
{

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withMaterialName($value)
    {
        $this->data['MaterialName'] = $value;
        $this->options['form_params']['MaterialName'] = $value;

        return $this;
    }

    /**
     * @param array $elementList
     *
     * @return $this
     */
	public function withElementList(array $elementList)
	{
	    $this->data['ElementList'] = $elementList;
		foreach ($elementList as $depth1 => $depth1Value) {
			if(isset($depth1Value['ImageUrl'])){
				$this->options['form_params']['ElementList.' . ($depth1 + 1) . '.ImageUrl'] = $depth1Value['ImageUrl'];
			}
			if(isset($depth1Value['SideName'])){
				$this->options['form_params']['ElementList.' . ($depth1 + 1) . '.SideName'] = $depth1Value['SideName'];
			}
		}

		return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withDataId($value)
    {
        $this->data['DataId'] = $value;
        $this->options['form_params']['DataId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withMaterialType($value)
    {
        $this->data['MaterialType'] = $value;
        $this->options['form_params']['MaterialType'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withModelType($value)
    {
        $this->data['ModelType'] = $value;
        $this->options['form_params']['ModelType'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withCategory($value)
    {
        $this->data['Category'] = $value;
        $this->options['form_params']['Category'] = $value;

        return $this;
    }
}

/**
 * @method string getUrl()
 * @method string getColorCount()
 */
class RecognizeImageColor extends Rpc
{

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withUrl($value)
    {
        $this->data['Url'] = $value;
        $this->options['form_params']['Url'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withColorCount($value)
    {
        $this->data['ColorCount'] = $value;
        $this->options['form_params']['ColorCount'] = $value;

        return $this;
    }
}

/**
 * @method string getUrl()
 */
class RecognizeImageStyle extends Rpc
{

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withUrl($value)
    {
        $this->data['Url'] = $value;
        $this->options['form_params']['Url'] = $value;

        return $this;
    }
}

/**
 * @method array getColorTemplate()
 * @method string getUrl()
 * @method string getMode()
 * @method string getColorCount()
 * @method string getRefUrl()
 */
class RecolorImage extends Rpc
{

    /**
     * @param array $colorTemplate
     *
     * @return $this
     */
	public function withColorTemplate(array $colorTemplate)
	{
	    $this->data['ColorTemplate'] = $colorTemplate;
		foreach ($colorTemplate as $depth1 => $depth1Value) {
			if(isset($depth1Value['Color'])){
				$this->options['form_params']['ColorTemplate.' . ($depth1 + 1) . '.Color'] = $depth1Value['Color'];
			}
		}

		return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withUrl($value)
    {
        $this->data['Url'] = $value;
        $this->options['form_params']['Url'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withMode($value)
    {
        $this->data['Mode'] = $value;
        $this->options['form_params']['Mode'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withColorCount($value)
    {
        $this->data['ColorCount'] = $value;
        $this->options['form_params']['ColorCount'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withRefUrl($value)
    {
        $this->data['RefUrl'] = $value;
        $this->options['form_params']['RefUrl'] = $value;

        return $this;
    }
}

/**
 * @method string getDisplayType()
 * @method string getMaterialName()
 * @method string getJobId()
 * @method string getMaterialType()
 * @method string getModelType()
 * @method string getTargetWidth()
 * @method array getElementList()
 * @method string getCategory()
 * @method string getTargetHeight()
 */
class RenderImageForPackageDesign extends Rpc
{

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withDisplayType($value)
    {
        $this->data['DisplayType'] = $value;
        $this->options['form_params']['DisplayType'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withMaterialName($value)
    {
        $this->data['MaterialName'] = $value;
        $this->options['form_params']['MaterialName'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withJobId($value)
    {
        $this->data['JobId'] = $value;
        $this->options['form_params']['JobId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withMaterialType($value)
    {
        $this->data['MaterialType'] = $value;
        $this->options['form_params']['MaterialType'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withModelType($value)
    {
        $this->data['ModelType'] = $value;
        $this->options['form_params']['ModelType'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withTargetWidth($value)
    {
        $this->data['TargetWidth'] = $value;
        $this->options['form_params']['TargetWidth'] = $value;

        return $this;
    }

    /**
     * @param array $elementList
     *
     * @return $this
     */
	public function withElementList(array $elementList)
	{
	    $this->data['ElementList'] = $elementList;
		foreach ($elementList as $depth1 => $depth1Value) {
			if(isset($depth1Value['ImageUrl'])){
				$this->options['form_params']['ElementList.' . ($depth1 + 1) . '.ImageUrl'] = $depth1Value['ImageUrl'];
			}
			if(isset($depth1Value['SideName'])){
				$this->options['form_params']['ElementList.' . ($depth1 + 1) . '.SideName'] = $depth1Value['SideName'];
			}
		}

		return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withCategory($value)
    {
        $this->data['Category'] = $value;
        $this->options['form_params']['Category'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withTargetHeight($value)
    {
        $this->data['TargetHeight'] = $value;
        $this->options['form_params']['TargetHeight'] = $value;

        return $this;
    }
}

/**
 * @method string getImageUrl()
 */
class SegmentBody extends Rpc
{

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withImageUrl($value)
    {
        $this->data['ImageUrl'] = $value;
        $this->options['form_params']['ImageUrl'] = $value;

        return $this;
    }
}

/**
 * @method string getUrl()
 */
class SegmentImage extends Rpc
{

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withUrl($value)
    {
        $this->data['Url'] = $value;
        $this->options['form_params']['Url'] = $value;

        return $this;
    }
}
