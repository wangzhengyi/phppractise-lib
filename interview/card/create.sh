#!/bin/bash

#随机创造18位身份证号码

for j in `seq 1 30000`
do
	card=''
	for i in `seq 1 18`
	do
		random=`expr $RANDOM % 10`
		card=$card$random
	done
	
	for k in `seq 1 $j`
	do
		echo $card >> card.txt
	done

done
