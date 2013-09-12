/**
 * 阿里2013年一道求中位数的笔试题目，这里只考虑n为奇数的情况
 */

#include <stdio.h>
#include <stdlib.h>


int dividePivot(int *arr, int begin, int end)
{
	int stand = arr[begin];
	while (begin < end) {
		while (begin < end && arr[end] >= stand) {
			end --;
		}
		if (begin < end) {
			arr[begin ++] = arr[end];
		}

		while (begin < end && arr[begin] <= stand) {
			begin ++;
		}
		if (begin < end) {
			arr[end --] = arr[begin];
		}
	}

	arr[begin] = stand;
	return begin;
}

int middleLoc(int *arr, int st, int ed, int n)
{
	int pivot;

	while (st <= ed) {
		pivot = dividePivot(arr, st, ed);
		if (pivot == (n - 1) / 2) {
			return arr[pivot];
		} else if (pivot > (n - 1) / 2) {
			ed = pivot - 1;
		} else {
			st = pivot + 1;
		}
	}

	return -1;
}


int main(void)
{
	int i, n, index, *arr;

	while (scanf("%d", &n) != EOF) {
		arr = (int *)malloc(sizeof(int) * n);
		for (i = 0; i < n; i ++)
			scanf("%d", arr + i);

		if (arr == NULL)	return 0;

		index = middleLoc(arr, 0, n - 1, n);

		printf("%d\n", index);

		free(arr);
	}

	return 0;
}
