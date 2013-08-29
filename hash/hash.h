#ifndef HASH_H
#define HASH_H

#define HASH_TABLE_INIT_SIZE 7

#define SUCCESS 1
#define FAILED 0


/**
 * 哈希表槽的数据结构
 */
typedef struct Bucket {
	char *key;
	void *value;
	struct Bucket *next;
} Bucket;

/**
 * 哈希表数据结构
 */
typedef struct HashTable {
	int size;	// 哈希表大小
	int elem_num;	// 哈希表已经保存的数据元素个数
	Bucket **buckets;
} HashTable;

int hashIndex(HashTable *ht, char *key);
int hashInit(HashTable *ht);
int hashLookup(HashTable *ht, char *key, void **result);
int hashInsert(HashTable *ht, char *key, void *value);
int hashRemove(HashTable *ht, char *key);
int hashDestory(HashTable *ht);
#endif
