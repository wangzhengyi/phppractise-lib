#include <stdio.h>

#pragma pack(4)

typedef struct A {
	int a;
	short b;
	int c;
	char d;
} A;

typedef struct B {
	int a;
	short b;
	char c;
	int d;
} B;

int main(void)
{
	A a;
	B b;

	printf("%d %d\n", sizeof(a), sizeof(b));

	return 0;
}
