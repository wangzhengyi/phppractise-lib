#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <assert.h>
#include "hash.h"

int main(int argc, char **argv)
{
	HashTable *ht = (HashTable *)malloc(sizeof(HashTable));
	int result = hashInit(ht);

	assert(result == SUCCESS);

	/* Data */
	int int1 = 10;
	int int2 = 20;
	char str1[] = "Hello World!";
	char str2[] = "Value";
	char str3[] = "Hello New World!";

	/* to find data container */
	int *j = NULL;
	char *find_str = NULL;

	/* Test Key Insert */
	printf("Key Insert:\n");
	hashInsert(ht, "FirInt", &int1);
	hashInsert(ht, "FirStr", str1);
	hashInsert(ht, "SecStr", str2);
	printf("Pass Insert\n");

	/* Test Key Lookup*/
	printf("Key Lookup:\n");
	result = hashLookup(ht, "FirStr", &find_str);
	assert(result == SUCCESS);
	printf("pass lookup, the value is %s\n", find_str);

	/* Test Update */
	printf("Key Update:\n");
	hashInsert(ht, "FirStr", str3);
	result = hashLookup(ht, "FirStr", &find_str);
	assert(result == SUCCESS);
	printf("pass update, the value is %s\n", find_str);

	return 0;
}
