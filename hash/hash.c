#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "hash.h"

/**
 * 初始化哈希表
 *
 * T = O(1)
 *
 */
int hashInit(HashTable *ht)
{
	ht->size = HASH_TABLE_INIT_SIZE;
	ht->elem_num = 0;
	ht->buckets = (Bucket **)calloc(ht->size, sizeof(Bucket *));

	if (ht->buckets == NULL)
		return FAILED;
	else
		return SUCCESS;
}

/**
 * 散列函数
 *
 * T = O(n)
 *
 */
int hashIndex(HashTable *ht, char *key)
{
	int hash = 0;

	while (*key != '\0') {
		hash += (int)*key;
		key ++;
	}

	return hash % ht->size;
}

/**
 * 哈希查找函数
 *
 * T = O(n)
 *
 */
int hashLookup(HashTable *ht, char *key, void **result)
{
	int index = hashIndex(ht, key);

	Bucket *bucket = ht->buckets[index];

	while (bucket) {
		if (strcmp(bucket->key, key) == 0) {
			*result = bucket->value;
			return SUCCESS;
		}
		bucket = bucket->next;
	}

	return FAILED;
}


/**
 * 哈希表插入操作
 *
 * T = O(1)
 *
 */
int hashInsert(HashTable *ht, char *key, void *value)
{
	int index = hashIndex(ht, key);

	Bucket *org_bucket, *tmp_bucket;
	org_bucket = tmp_bucket = ht->buckets[index];

	// 检查key是否已经存在于hash表中
	while (tmp_bucket) {
		if (strcmp(tmp_bucket->key, key) == 0) {
			tmp_bucket->value = value;
			return SUCCESS;
		}
		tmp_bucket = tmp_bucket->next;
	}

	Bucket *new = (Bucket *)malloc(sizeof(Bucket));
	
	if (new == NULL)	return FAILED;

	new->key = key;
	new->value = value;
	new->next = NULL;

	ht->elem_num += 1;

	// 头插法
	if (org_bucket) {
		new->next = org_bucket;
	}

	ht->buckets[index] = new;

	return SUCCESS; 
}

/**
 * 哈希删除函数
 *
 * T = O(n)
 *
 */
int hashRemove(HashTable *ht, char *key)
{
	int index = hashIndex(ht, key);

	Bucket *pre, *cur, *post;

	pre = NULL;
	cur = ht->buckets[index];

	while (cur) {
		if (strcmp(cur->key, key) == 0) {
			post = cur->next;
			
			if (pre == NULL) {
				ht->buckets[index] = post;
			} else {
				pre->next = post;
			}

			free(cur);

			return SUCCESS;
		}

		pre = cur;
		cur = cur->next;
	}

	return FAILED;
}

/**
 * 哈希表销毁函数
 *
 * T = O(n)
 */
int hashDestory(HashTable *ht)
{
	int i;
	Bucket *cur, *tmp;

	cur = tmp = NULL;

	for (i = 0; i < ht->size; i ++) {
		cur = ht->buckets[i];

		while (cur) {
			tmp = cur->next;
			free(cur);
			cur = tmp;
		}
	}

	free(ht->buckets);

	return SUCCESS;
}
