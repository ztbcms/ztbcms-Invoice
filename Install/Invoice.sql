
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `cms_invoice_config`;
CREATE TABLE `cms_invoice_config`  (
  `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT,
  `xsf_nsrsbh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '销售方纳税人识别号',
  `xsf_mc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '销售方名称',
  `xsf_dzdhxsf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '销售方地址、电话',
  `xsf_yhzh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '销售方银行账号',
  `xsf_lxfs` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '销售方移动电话或邮箱',
  `kpr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '开票人',
  `sl` decimal(10, 2) UNSIGNED NULL DEFAULT NULL COMMENT '税率',
  `add_time` int(15) UNSIGNED NULL DEFAULT NULL COMMENT '创建时间',
  `edit_time` int(15) UNSIGNED NULL DEFAULT NULL COMMENT '最后编辑时间',
  `is_delete` int(1) UNSIGNED NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;


DROP TABLE IF EXISTS `cms_invoice_log`;
CREATE TABLE `cms_invoice_log`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `request_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '请求地址 ',
  `request_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '请求的参数 ',
  `order_sn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '订单号',
  `return_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '返回的内容',
  `add_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '请求时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
