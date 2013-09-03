#include <stdio.h>
#include <stdlib.h>
#include <string.h>

typedef struct node {
	int num;
	struct node *next;
} node;

/**
 * 构建循环链表
 */
node* creakCircle(int n)
{
	node *head, *cur, *new;
	int i;

	head = (node *)malloc(sizeof(head));
	head->num = 1;
	head->next = NULL;

	cur = head;

	for (i = 2; i <= n; i ++) {
		new = (node *)malloc(sizeof(node));
		new->num = i;
		new->next = NULL;
		cur->next = new;
		cur = new;
	}

	cur->next = head;

	return head;
}

/**
 * 约瑟环踢出代码
 */
void killCircle(node *head, int k)
{
	node *p, *q;
	int i;

	p = q = head;

	while (p->next != p) {	
		for (i = 1; i < k; i ++) {
			q = p;
			p = p->next;
		}
		// 打印踢出的同学
		printf("%d ", p->num);

		q->next = p->next;
		free(p);
		p = q->next;
	}

	printf("%d\n", p->num);

	free(p);
}

/**
 * 报数为1的情况
 */
void printCircle(node *head, int k)
{
	node *cur;
	
	cur = head;

	while (cur->next != head) {
		printf("%d ", cur->num);
		cur = cur->next;
	}
	printf("%d\n", cur->num);
}

int main(void)
{
	int n, k;
	node *head;

	while (scanf("%d %d", &n, &k) != EOF) {
		head = creakCircle(n);
			
		if (k == 1)
			printCircle(head, k);
		else
			killCircle(head, k);
	}

	return 0;
}
