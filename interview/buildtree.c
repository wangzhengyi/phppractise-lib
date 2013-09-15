/**
 * 根据中序和后序序列构建二叉树
 * (ps:昨晚参加阿里笔试，等到最后说可以免笔试直接面试，今天估计还是要根据学校筛选，哈哈，为了这点
 * 也得参加阿里笔试，不能让自己的学校受到鄙视)
 */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>

int n;

typedef struct btree {
	struct btree *lchild;
	struct btree *rchild;
	char data;
} btree;

/**
 * 中序、后序序列构建二叉树
 */
btree* rebuildTree(char *order, char *post, int len)
{
	btree *t;

	if (len <= 0) {
		return NULL;
	} else {
		int index = 0;

		while (index < len && *(post + len - 1) != *(order + index)) {
			index ++;
		}	

		t = (btree *)malloc(sizeof(btree));
		t->data = *(order + index);
		t->lchild = rebuildTree(order, post, index);
		t->rchild = rebuildTree(order + index + 1, post + index, len - (index + 1));
	}

	return t;
}

/**
 * 前序遍历二叉树
 */
void preTraverse(btree *t)
{
	if (t) {
		printf("%c ", t->data);
		preTraverse(t->lchild);
		preTraverse(t->rchild);
	}
}

int main(void)
{
	int i;
	char *post, *order;
	btree *t;

	while (scanf("%d", &n) != EOF) {
		post = (char *)malloc(n);
		order = (char *)malloc(n);
		
		getchar();
		for (i = 0; i < n; i ++)
			scanf("%c", order + i);

		getchar();
		for (i = 0; i < n; i ++)
			scanf("%c", post + i);

		t = rebuildTree(order, post, n);

		preTraverse(t);
		printf("\n");

		free(post);
		free(order);

	}

	return 0;
}
