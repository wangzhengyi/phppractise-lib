#!/bin/awk -f

#运行前
BEGIN {
	FS = " ";
	count = 0;
}

#运行中
{
	iparr[count ++] = $0;
}

#运行后
END {
	printf("<?php\n");
	printf("$iparr = array(\n");
	for (i = 0; i < count; i ++) {
		printf("'%s' => '%s',\n", iparr[i], iparr[i]);
	}
	printf(");\n");
}
