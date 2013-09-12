#include <stdio.h>

int count;	// 全局变量，记录arr[i] = i


void staticArr(int *arr, int begin, int end)
{
	int mid;
	
	if (begin <= end) {
		mid = (begin + end) / 2;

		if (arr[mid] > mid) {
			staticArr(arr, begin, end - 1);
		} else if (arr[mid] < mid) {
			staticArr(arr, mid + 1, end);
		} else {
			count ++;
			staticArr(arr, begin, mid - 1);
			staticArr(arr, mid + 1, end);
		}
	}
}

int main(void)
{
	int i, n, arr[1000];

	while (scanf("%d", &n) != EOF) {
		count = 0;

		for (i = 0; i < n; i ++)
			scanf("%d", &arr[i]);

		staticArr(arr, 0, n - 1);

		printf("%d\n", count);
	}

	return 0;
}
