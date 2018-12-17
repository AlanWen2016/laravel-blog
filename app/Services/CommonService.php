<?php
namespace App\Services;

class CommonService{

    public static function getInstance()
    {
        static $instance;
        if(isset($instance)) {
            return $instance;
        }
        $instance = new static();
        return $instance;
    }

    /**
     * 使用正则验证数据
     * @access public
     * @param string $value  要验证的数据
     * @param string $rule 验证规则
     * @return boolean
     */
    public static function regex($value, $rule) {
        if(!is_string($value) && !is_numeric($value)){
            return false;
        }
        $validate = array(
            'require'   =>  '/\S+/',
            'email'     =>  '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
            //'url'       =>  '/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(:\d+)?(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/i',
            'url'       =>  '/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(:\d+)?(?:.*)?$/i',
            'currency'  =>  '/^\d+(\.\d+)?$/',
            'number'    =>  '/^\d+$/',
            'date'		=>  '/^([0-9]{3}[1-9]|[0-9]{2}[1-9][0-9]{1}|[0-9]{1}[1-9][0-9]{2}|[1-9][0-9]{3})-(((0[13578]|1[02])-(0[1-9]|[12][0-9]|3[01]))|((0[469]|11)-(0[1-9]|[12][0-9]|30))|(02-(0[1-9]|[1][0-9]|2[0-8])))$/',
            'zip'       =>  '/^\d{6}$/',
            'integer'   =>  '/^[-\+]?\d+$/',
            'double'    =>  '/^[-\+]?\d+(\.\d+)?$/',
            'english'   =>  '/^[A-Za-z]+$/',
            'phone' 	=> '/^1[34578]\d{9}$/',
            'qq' 		=> '/^[1-9]\d{4,10}$/',
            'vid' 		=> '/^[0-9a-zA-Z]{11}$/',
            'rtx' 		=> '/^(v_)?[a-z]+$/',
            'rtxList'	=> '/^;*(v_)?[a-z]+(;+(v_)?[a-z]+)*;*$'  #分号 分隔的多个rtx
        );
        // 检查是否有内置的正则表达式
        if(isset($validate[strtolower($rule)]))
            $rule = $validate[strtolower($rule)];
        return preg_match($rule, $value)===1;
    }


    public function formatShowTime($date) {
        $date = str_replace('-', '/', $date);
        $date = date('y/m/d H:i:s', strtotime($date));
        return $date;
    }

    /**
     * 过滤ID字符串
     * @param int|array $ids
     * @param bool $flag 是否做整型转换处理
     * @return array
     */
    public static function parseIds($ids,$flag=true) {
        if (is_array($ids)) {
            $idsArr = $ids;
        } else {
            $idsArr = explode(',', $ids);
        }
        $newIdsArr = array();
        foreach($idsArr as $k => $v) {
            if($flag){
                $tmp = intval($v);
                if ($tmp) {
                    array_push($newIdsArr, $tmp);
                }
            }else{
                array_push($newIdsArr, $v);
            }
        }
        $newIdsArr = array_unique($newIdsArr);
        return $newIdsArr;
    }

    /**
     * @param $param
     * @param $configMap
     * @return array
     * @throws \Exception
     * $map = [
     *      'pKey' => ['name' => '标识'],
     *      'dataUrl' => ['name' => '数据链接', 'optional' => true],
     *      'order' => ['name' => '排序', 'optional' => true,'type' => 'number','default' => 0]
     *  ];
     */
    public function handleParamWithConfig($param,$configMap){
        $edit = [];
        foreach($configMap as $key => $config){
            $field = empty($config['field']) ? $key : $config['field'];
            $fieldName = $config['name'];
            if(empty($param[$field])){
                $default = '';
                if(empty($config['optional'])){ // 如果不是可选的
                    throw(new \Exception($fieldName.'不能为空'));
                }elseif(isset($config['default'])){
                    $default = $config['default'];
                }
                $edit[$field] = $default;
                continue;
            }
            $fieldValue = $param[$field];
            if(!empty($config['type']) && !self::regex($fieldValue,$config['type'])){
                throw(new \Exception($fieldName.'格式不正确'));
            }
            $edit[$field] = $fieldValue;
        }
        return $edit;
    }

    /**
     * 输出json结果
     * @param  [type] $retCode [description]
     * @param  [type] $msg     [description]
     * @param  [type] $data    [description]
     * @return [type]          [description]
     */
    protected function get_service_result($retCode, $msg, $data=NULL)
    {
        $serviceJsonResult = [
            'code' => $retCode,
            'msg'  => $msg,
        ];
        if(!empty($data)){
            $serviceJsonResult['data'] = $data;
        }
        return $serviceJsonResult;
    }

    /**
     * 输出json结果：成功
     * @param  [type] $retCode [description]
     * @param  [type] $msg     [description]
     * @param  [type] $data    [description]
     * @return [type]          [description]
     */
    protected function service_success($msg, $data=NULL)
    {
        return $this->get_service_result(0, $msg, $data);
    }

    /**
     * 输出json结果：异常
     * @param  [type] $retCode [description]
     * @param  [type] $msg     [description]
     * @param  [type] $data    [description]
     * @return [type]          [description]
     */
    protected function service_failure($msg, $data=NULL)
    {
        return $this->get_service_result(-1, $msg, $data);
    }

    /**
     * 根据key获取数组中的内容
     * @param  [type] &$arrayData [description]
     * @param  [type] $keys       [description]
     * @param  string $defValue   [description]
     * @return [type]             [description]
     */
    protected function getArrayDataByKeys(&$arrayData, $keys, $defValue = '')
    {
        if(count($keys) === 0){
            return [];
        }

        $data = [];
        foreach($keys as $k => $v) {
            if (is_numeric($k)) {
                $field = $v;
                $default = '';
            } else {
                $field = $k;
                $default = $v;
            }
            $data[$field] = isset($arrayData[$field]) ? $arrayData[$field] : $default;
        }
        return $data;
    }
}