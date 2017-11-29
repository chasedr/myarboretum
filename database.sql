CREATE TABLE `myarboretum`.`maintainplan` ( 
	`maintainplan_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '行号' ,

	`maintainplan_plantname` VARCHAR(100) NOT NULL COMMENT '计划名以植物命名' ,

	`maintainplan_method1` VARCHAR(100) NOT NULL COMMENT '培育方式' ,

	`maintainplan_method2` VARCHAR(100) NOT NULL COMMENT '养护方式' ,

	`maintainplan_lux` VARCHAR(100) NOT NULL COMMENT '光照' ,

	`maintainplan_temp` VARCHAR(100) NOT NULL COMMENT '温度' ,

	`maintainplan_dampair` VARCHAR(100) NOT NULL COMMENT '湿度-空气' ,

	`maintainplan_dampsoil` VARCHAR(100) NOT NULL COMMENT '湿度-土壤' ,

	`maintainplan_manure` VARCHAR(100) NOT NULL COMMENT '施肥' ,

	`maintainplan_changepot` VARCHAR(100) NOT NULL COMMENT '换土' ,

	`maintainplan_soilquality` VARCHAR(100) NOT NULL COMMENT '土壤质量' ,

	`maintainplan_soilPH` VARCHAR(100) NOT NULL COMMENT '土壤PH值' ,

	`maintainplan_air` VARCHAR(100) NOT NULL COMMENT '通风' ,

	`maintainplan_period` INT(11) NOT NULL COMMENT '养护周期' ,

	`maintainplan_plantdetails` VARCHAR(100) NOT NULL COMMENT '养护计划细节' ,

	`maintainplan_inserttime` TIMESTAMP NOT NULL COMMENT '插入时间' ,

	`maintainplan_usedcount` INT(11) NOT NULL COMMENT '引用次数' ,

	`maintainplan_user_id` INT(11) NOT NULL COMMENT '创建计划的用户id' ,

	`maintainplan_version` INT(11) NOT NULL COMMENT '计划的版本' ,

	PRIMARY KEY (`maintainplan_id`) ENGINE = InnoDB COMMENT = '养护计划模板用于记录护花计划计划所有养护方案'
);