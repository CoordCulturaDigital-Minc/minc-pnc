<?php

// inclui os arquivos
$autoinclude_base_dir = dirname(__FILE__) . '/';

// inclui o arquivo de sctipts de atualização da base de dados
include $autoinclude_base_dir . '/db-updates.php';

include $autoinclude_base_dir . '/EasyAjax.php';

$autoinclude_folders = array(
    'metaboxes/',
    'post-types/',
    'taxonomies/',
    'template-widgets/',
    'theme-options/',
    'widgets/',
    'shortcodes/'
);
foreach ($autoinclude_folders as $folder) {
    if (file_exists($autoinclude_base_dir . $folder)) {
        $dir = opendir($autoinclude_base_dir . $folder);
        while (false !== ($d = readdir($dir))) {
            if (strpos($d, '.php')) {
                require_once $autoinclude_base_dir . $folder . $d;
            }
        }
    }
}

WidgetUniquePost::init();
WidgetMultiplePost::init();

/**
 * Runtime Cache
 * @example <pre>
 * 	function exemplo($nome){
 * 		if(RCache::exists(__METHOD__,$nome))
 * 			return RCache::get(__METHOD__,$nome);
 * 		...
 * 		$result = "ALGUMA COISA";
 * 		RCache::set(__METHOD__, $nome, $result);
 * 		return $result;
 *  } 
 *  </pre>
 * @author rafael
 */
class RCache {

    private static $data = array();

    /**
     * Salva o cache
     * @param string $group pode ser usado __METHOD__ 
     * @param string $id um identificador para o cache, deve ser único para o mesmo $group
     * @param mixed $data o que deve ser cacheado
     * @example RCache::set(__METHOD__, $post_id, $post);
     */
    public static function set($group, $id, $data) {
        self::$data[$group][$id] = $data;
    }

    /**
     * Verifica se o cache existe
     * @param string $group
     * @param string $id
     * @example RCache::exists(__METHOD__, $post_id);
     * @return boolean
     */
    public static function exists($group, $id) {
        return isset(self::$data[$group][$id]);
    }

    /**
     * Retorna o que estiver cacheado
     * @param string $group 
     * @param string $id
     * @example $value = RCache(__METHOD__, $post_id);
     * @return mixed o que estiver cacheado ou null se o cache não existir
     */
    public static function get($group, $id) {
        if (self::exists($group, $id))
            return self::$data[$group][$id];
        else
            return null;
    }

    /**
     * Deleta o valor cacheado
     * @param string $group
     * @param string $id
     */
    public static function delete($group, $id) {
        unset(self::$data[$group][$id]);
    }

}

/**
 * Disk Cache
 * @example <pre>
 * 	function exemplo($nome){
 * 		if(DCache::exists(__METHOD__,$nome))
 * 			return DCache::get(__METHOD__,$nome);
 * 		...
 * 		$result = "ALGUMA COISA";
 * 		DCache::set(__METHOD__, $nome, $result);
 * 		return $result;
 *  } 
 *  </pre>
 * @author rafael
 */
class DCache {

    protected static function getPath() {

        if (defined('DCACHE_PATH') && is_writable(DCACHE_PATH)) {
            return DCACHE_PATH;
        } else {
            if (is_writable(ABSPATH . '/wp-content/uploads/.disk_cache')) {
                return ABSPATH . '/wp-content/uploads/.disk_cache';
            } elseif (is_writable(ABSPATH . '/wp-content/uploads')) {
                mkdir(ABSPATH . '/wp-content/uploads/.disk_cache');
                return ABSPATH . '/wp-content/uploads/.disk_cache';
            } else {
                $dir = '/tmp/' . md5(__FILE__);
                if (!file_exists($dir))
                    mkdir($dir);
                return $dir;
            }
        }
    }

    protected static function getFilename($group, $id) {
        if (!is_dir(self::getPath() . '/' . md5($group)))
            mkdir(self::getPath() . '/' . md5($group));
        return self::getPath() . '/' . md5($group) . '/' . md5($id) . '.cache';
    }

    /**
     * Salva o cache
     * @param string $group pode ser usado __METHOD__ 
     * @param string $id um identificador para o cache, deve ser único para o mesmo $group
     * @param mixed $data o que deve ser cacheado
     * @example DCache::set(__METHOD__, $post_id, $post);
     */
    public static function set($group, $id, $data) {
        $filename = self::getFilename($group, $id);
        if (file_exists(self::getPath()) && is_writable(self::getPath())) {
            if (!file_exists($filename) || (file_exists($filename) && is_writable($filename)))
                file_put_contents($filename, serialize($data));
        }
    }

    /**
     * Verifica se o cache existe. Se o cache existe e estiver expirado, deleta e retorna false
     * @param string $group
     * @param string $id
     * @param int $expiration_time número em segundos que o cache expira
     * @example DCache::exists(__METHOD__, $post_id);
     * @return boolean
     */
    public static function exists($group, $id, $expiration_time = null) {
        $filename = self::getFilename($group, $id);
        $exists = file_exists($filename);
        if ($expiration_time && $exists) {
            $ftime = filemtime($filename);
            if (time() > $ftime + intval($expiration_time)) {
                unlink($filename);
                return false;
            }
        }
        return $exists;
    }

    /**
     * Retorna o que estiver cacheado
     * @param string $group 
     * @param string $id
     * @example $value = DCache(__METHOD__, $post_id);
     * @return mixed o que estiver cacheado ou null se o cache não existir
     */
    public static function get($group, $id) {
        if (self::exists($group, $id)) {
            $fcontent = file_get_contents(self::getFilename($group, $id));
            if (is_serialized($fcontent))
                return unserialize($fcontent);
            else
                return null;
        }else {
            return null;
        }
    }

    /**
     * Deleta o valor cacheado, se o id for nulo, apaga o grupo todo
     * @param string $group
     * @param string|null $id
     */
    public static function delete($group, $id = null) {

        $filename = self::getFilename($group, $id);
        if (file_exists($filename) && is_writable($filename))
            unlink($filename);

        if (is_null($id)) {

            $dirname = dirname($filename);

            if (is_dir($dirname)) {

                $handle = scandir($dirname);
                foreach ($handle as $file) {

                    if ($file == '.' || $file == '..')
                        continue;

                    unlink($dirname . '/' . $file);
                }

                rmdir($dirname);
            }
        }
    }

}

/* ======= DEBUG FUNCTIONS ========= */

/**
 * var_dump fashion executado somente se $HL_DEBUG estiver definida como true
 * @param mixed $var
 * @param boolean $die executa um die; no final
 */
function _vd($var, $die = false) {
    global $HL_DEBUG;


    if (isset($HL_DEBUG) && $HL_DEBUG === true) {
        $a = debug_backtrace();

        $F = str_replace(ABSPATH, '', $a[0]['file']);
        $L = $a[0]['line'];
        echo "<div style='text-align:left; border:2px solid red; background-color:white; color:black;'><strong>chamado em: <em>$F - (linha: $L)</em></strong><hr/>";
        echo '<div style="max-height:500px; width:100%; overflow:auto;"><pre>';
        var_dump($var);
        echo '</pre></div></div>';

        if ($die)
            die;
    }
}

/**
 * print_r fashion executado somente se $HL_DEBUG estiver definida como true
 * @param mixed $var
 * @param boolean $die executa um die; no final
 */
function _pr($var, $die = false) {
    global $HL_DEBUG;

    if (isset($HL_DEBUG) && $HL_DEBUG === true) {
        $a = debug_backtrace();

        $F = str_replace(ABSPATH, '', $a[0]['file']);
        $L = $a[0]['line'];
        echo "<div style='text-align:left; border:2px solid red; background-color:white; color:black; padding:7px; margin:7px;'><strong>chamado em: <em>$F - (linha: $L)</em></strong><hr/>";
        echo '<div style="max-height:500px; width:100%; overflow:auto;"><pre>';
        print_r($var);
        echo '</pre></div></div>';

        if ($die)
            die;
    }
}

/**
 * _pr(debug_backtrace()) somente se $HL_DEBUG estiver definida como true 
 * @param mixed $var
 * @param boolean $die executa um die; no final
 */
function _bt() {
    global $HL_DEBUG;
    if (isset($HL_DEBUG) && $HL_DEBUG === true) {
        _pr(debug_backtrace());
    }
}

/**
 * imprime <pre>print_r($var)</pre> somente se $HL_DEBUG estiver definida como true 
 * @param mixed $var
 * @param boolean $die executa um die; no final
 */
function _ps($var, $die = false) {
    global $HL_DEBUG;

    if (isset($HL_DEBUG) && $HL_DEBUG === true) {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}

/**
 * imprime um comentário HTML com a string enviada somente se $HL_DEBUG estiver definida como true<br />
 * bom para ser utilizado dentro dos template parts no inicio e no fim de cada um
 * @example _hc(__FILE__.' - INICIO'); imprime <!-- /caminho/para/arquivo.php - INICIO -->
 * @param unknown_type $string
 */
function _hc($string) {
    global $HL_DEBUG;

    if (isset($HL_DEBUG) && $HL_DEBUG === true) {
        $string = str_replace(THEME_PATH . '/', '', $string);
        echo "\n<!-- $string -->\n";
    }
}
