@echo off
REM Production Deployment Script for Personal Branding Website (Windows version)

REM Display help message
if "%1"=="-h" goto :help
if "%1"=="--help" goto :help

REM Check if force flag is set
set FORCE=false
if "%1"=="-f" set FORCE=true
if "%1"=="--force" set FORCE=true

REM Check if git is installed
where git >nul 2>nul
if %ERRORLEVEL% neq 0 (
    echo Error: git is not installed. Please install git and try again.
    exit /b 1
)

REM Check if docker is installed
where docker >nul 2>nul
if %ERRORLEVEL% neq 0 (
    echo Error: docker is not installed. Please install docker and try again.
    exit /b 1
)

REM Check if docker-compose is installed
where docker-compose >nul 2>nul
if %ERRORLEVEL% neq 0 (
    echo Error: docker-compose is not installed. Please install docker-compose and try again.
    exit /b 1
)

REM Check if make is installed
where make >nul 2>nul
if %ERRORLEVEL% neq 0 (
    echo Error: make is not installed. Please install make and try again.
    exit /b 1
)

REM Check if we're in a git repository
if not exist .git (
    echo Error: Not a git repository. Please run this script from the root of the git repository.
    exit /b 1
)

REM Check if there are uncommitted changes
git status --porcelain > temp.txt
set /p CHANGES=<temp.txt
del temp.txt
if not "%CHANGES%"=="" (
    echo Warning: There are uncommitted changes in the repository.
    if not "%FORCE%"=="true" (
        set /p CONTINUE=Do you want to continue anyway? (y/n)
        if /i not "%CONTINUE%"=="y" (
            echo Deployment aborted.
            exit /b 1
        )
    )
)

REM Pull latest changes from the repository
echo Pulling latest changes from the repository...
git pull

REM Deploy to production
echo Deploying to production...
make prod

echo Deployment completed successfully!
echo Your application is now running at: http://localhost:4001
exit /b 0

:help
echo Usage: deploy.bat [options]
echo.
echo Options:
echo   -h, --help     Display this help message
echo   -f, --force    Force deployment without confirmation
echo.
echo This script deploys the application to production.
exit /b 0
