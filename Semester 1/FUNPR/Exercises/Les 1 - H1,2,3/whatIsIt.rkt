(define atom?
  (lambda (x)
    (and (not (pair? x)) (not (null? x))
    )
  )
)

(define whatIsIt?
  (lambda (x)
    (cond
      ((number? x) 'number)
      ((atom? x) 'symbool)
      (else 'list)
      )))