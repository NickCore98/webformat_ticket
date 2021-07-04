-- QUERY TO GET ALL CROSS-TEAM PROJECTS
SELECT E.Title, Count(*) as N_Teams
FROM (
  SELECT A.Title, D.Team FROM project as A
  LEFT OUTER JOIN task as B on A.ID=B.Project
  LEFT OUTER JOIN assignment as C on B.ID=C.TASK
  LEFT OUTER JOIN employee as D on C.DEV=D.ID
  GROUP BY A.Title, D.Team) as E
GROUP BY E.Title
HAVING N_Teams>1;
