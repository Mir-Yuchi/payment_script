CREATE TABLE `invoices` (
  `id` int(11) NOT NULL COMMENT 'ID платежа',
  `amount` float NOT NULL COMMENT 'Сумма платежа',
  `special_number` float NOT NULL COMMENT 'Магическое число (для прямых переводов)',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время создания инвойса',
  `valid_until` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время до которого нужно оплатить',
  `is_paid` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Оплачен ли счет',
  `comment` text NOT NULL COMMENT 'Комментарий платежа',
  `notification_url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;