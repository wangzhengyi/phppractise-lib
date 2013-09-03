#include <stdio.h>
#include <stdlib.h>

int main(void)
{
	int n, count;

	while (scanf("%d", &n) != EOF) {
		count = 0;
		while (n) {
			if (n & 1)	count ++;
			n >>= 1;
		}
		printf("%d\n", count);
	}

	return 0;
}
