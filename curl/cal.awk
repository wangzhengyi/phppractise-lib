#!/bin/awk -f

BEGIN {
	FS = " ";
	i = 0;
}

{
	arr[i] = $1 + $2;
	i ++;
}

END {
	for (j = 0; j < i; j ++) {
		printf("%d\n", arr[j]);
	}
}
