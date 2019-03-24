<?php
/**
 * Created by IntelliJ IDEA.
 * User: ccheng
 * Date: 19-3-22
 * Time: 下午8:40
 */
namespace Lib\SelfTest;

class CTest{
    private static $_self;

    private $directory;     // 源文件路径
    private $file;          // 文件源内容


    private function __construct(string $directory) {
        $this ->directory = $directory;
        $this ->file = file($this ->directory);
    }

    public static function getInstance(...$params) {
        if (!self::$_self) self::$_self = new self(...$params);
        return self::$_self;
	}
	
	/**
	 * 返回指定函数所处位置
	 * @param string $function 要查找的函数
	 * @return int 该函数所处位置,如果为空则不存在此函数
	 */
	protected function getFunctionIndex(string $function):?int {
		foreach ($this ->file as $key =>$line) {
            if (count($f = explode('|', $line)) == 5) {
                if ($function == trim($f[1])) {
                    return $key;
                    break;
                }
            }
        }
	}

	/**
	 * 添加一条试题
	 * @param array|string $catalog 添加函数的所处目录,如果为空则新建, 如果为数组必须遵守参数键名,可以多个同时添加多个
	 * @param string $test 添加的函数的名称
	 * @param string $effect 添加的函数的作用说明
	 * @param string $skill  添加函数的更多说明
	 * @return bool 返回添加是否成功
	 */
    public function add($catalog, string $test = null,string $effect = null, string $skill = null):bool {
		if (is_array($catalog)) {
			if (is_string(key($catalog)) && is_array(current($catalog))) { // 同时添加多个
				foreach ($catalog as $key =>$value) {
					$this ->add($key, ...$value);
				}
			}else {
				$this ->add(...$catalog);
			}
		}else {
			if (!$test || !$effect || !$skill) throw new \Exception('add content is null');

			foreach ($this ->file as $key =>$value) {
				$ex = explode('|', $value);
				if (count($ex) >= 4 && trim($ex[1]) == $catalog) { 
					$this ->file[$key + 1] = '| ' . trim($test) . ' | ' . trim($effect) . ' | ' . trim($skill) . ' |' . PHP_EOL;
					return true;
				}
			}
			// 当前分类是新分类,需要添加分类
			if (is_string($catalog)) {
				$this ->file[] = '| ' . trim($catalog) . ' |  |  |' . PHP_EOL;
				$this ->file[] = '| ' . trim($test) . ' | ' . trim($effect) . ' | ' . trim($skill) . ' |' . PHP_EOL;
				return true;
			}
		}
		return false;
    }

    /**
     * 删除指定的条目
     * @param $function 函数名
	 * @return bool 删除是否成功
     */
    public function delete($function):bool {
		if (is_numeric(($index = $this ->getFunctionIndex($function)))){
			unset($this ->file[$index]);
			return true;
		}else return false;
    }

	/**
	 * 更新指定的试题
	 * @param string $name 要修改的函数
	 * @param array|string $replace_name 修改为该内容,如果可以为数组,如果为空则不修改函数本身
	 * @param string $replace_effetc 修改函数
	 * @param string $skill 修改函数说明
	 * @return bool 修改是否成功
	 */
    public function edit(string $name, $replace_name, string $replace_effetc = null, string $replace_skill = null):bool {
		$index = $this ->getFunctionIndex($name);
		if (!is_numeric($index)) return false;

		$_edit = function($n, $effetc, $skill) use ($index) {
			foreach (func_get_args() as $key =>$param){
				if (!func_get_args()[$key] = trim($param)) throw new \Exception("修改内容不能为空");
			}
			$this ->file[$index] = '| ' . implode(' | ', func_get_args()) . ' |' . PHP_EOL;
			return true;
		};

		if ($replace_name){
			if (is_array($replace_name)) {
				return $_edit($replace_name['name']??$name, $replace_name['effetc']??'', $replace_name['skill']??'');
			}else{
				return $_edit($replace_name, $replace_effetc, $replace_skill);
			}
		}else {
			return $_edit($name, $replace_effetc, $replace_skill);
		}
		return false;
    }

    public function __destruct() {
        // 将整理过的内容写入到源文件
        file_put_contents($this ->directory . '.bak', implode('', $this ->file));
    }
}