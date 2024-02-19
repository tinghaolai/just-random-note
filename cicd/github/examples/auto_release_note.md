Add next after release.

```
name: Update Release Notes-2

on:
  release:
    types: [published, unpublished]

jobs:
  update-release-notes:
    permissions: write-all
    runs-on: ubuntu-latest
    steps:
      - name: Update Release
        uses: actions/github-script@v4
        with:
          github-token: ${{ secrets.GITHUB_TOKEN }}
          script: |
            let updatedNote = context.payload.release.body;
            updatedNote += "\n\n\n\n text to add......";
            
            github.repos.updateRelease({
              owner: context.repo.owner,
              repo: context.repo.repo,
              release_id: context.payload.release.id,
              body: updatedNote
            });
```
