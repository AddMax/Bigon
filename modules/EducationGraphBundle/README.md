# EducationGraphBundle

## График образовательного процесса

Подключение:

1. добавить в routes.yaml

   graph_bundle:
    resource: '@EducationGraphBundle/config/routes.yaml'
    prefix: /admin

2. добавить в webpack

    .addEntry('education-graph-editor-app', './vendor/kudin/education-graph/assets/js/educational-graph/entryPoint.js')

3.
