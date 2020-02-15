<?php
//-----------------------------------------------------
// TagCloud for Opencart v1.5.1    
// Created by villagedefrance                          
// contact@villagedefrance.net                                    
//-----------------------------------------------------

class ModelModuleTagCloud extends Model {

	public function getRandomTags($limit = 5, $min_font_size = 9, $max_font_size = 25, $font_weight) {
		$product_id	= array();
		$names			= array();
		$totals			= array();
		$tags			= array();
		$tagcloud		= false;
		
		$tagNameQuery = $this->db->query("SELECT DISTINCT tag FROM " . DB_PREFIX . "product_tag WHERE language_id=" . (int)$this->config->get('config_language_id') . " LIMIT " . (int)$limit);
		
		if (count($tagNameQuery->rows) > 0) {
			foreach ($tagNameQuery->rows as $row) {
				$tagCountQuery = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_tag WHERE product_id = '" . $product_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
				$names[]	= $row['tag'];
				$totals[]	= $tagCountQuery->num_rows;
			}

			$tags = array_combine($names, $totals);

			$tagcloud = $this->generateTagCloud($tags, true, $min_font_size, $max_font_size, $font_weight);
		}
		
		return $tagcloud;
	}

	private function generateTagCloud($tags, $resize = true, $min_font_size = 9, $max_font_size = 25, $font_weight) {

		if ($resize == true) {
			arsort($tags);

			$max_qty = max(array_values($tags));
			$min_qty = min(array_values($tags));

			$spread = $max_qty - $min_qty;

			if ($spread == 0) {
				$spread = 1;
			}

			$step = ((int)$max_font_size - (int)$min_font_size) / ($spread);

			$cloud = array();

			foreach ($tags as $key => $value) {
				$size=rand((int)$min_font_size,(int)$max_font_size);
			
				$cloud[] = '<a href="' . $this->url->link('product/search', 'filter_tag=' . $key) . '" style="text-decoration:none;font-size:' . $size . 'px;font-weight:' . $font_weight . ';" title="">' . $key . '</a> ';
			}
			
		} else {
		
			foreach ($tags as $key => $value) {
				$cloud[] = '<a href="' . $this->url->link('product/search', 'filter_tag=' . $key) . '" style="text-decoration:none;" title="">' . $key . '</a> ';
			}
		}

		$tagcloud = '';

		shuffle($cloud);

		for ($x = 0; $x < count($cloud); $x++) {
			$tagcloud .= $cloud[$x];
		}

		return $tagcloud;
	}
}
?>