
## Grep ignore
git grep -i user-token  -- ':!*.js'

## Search in folder
git grep -i user-token resources/js

## Exclude folder

git grep -i identity -- ':!public'

## Write output to file

git grep -i identity -- ':!public' * > output-file

## Stash folder

git stash push -- public

## Soft reset

git reset --soft head^
