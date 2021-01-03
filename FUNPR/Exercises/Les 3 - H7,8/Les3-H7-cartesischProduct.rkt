
(define atom?
  (lambda (x)
    (and (not (pair? x)) (not (null? x))
    )
  )
)

(define lat?
  (lambda (l)
    (cond
	((null? l) #t)
	((atom? (car l)) (lat? (cdr l)))
	(else #f)
    )
  )
)

(define member?
  (lambda (a lat)
    (cond
      ((null? lat) #f)
      (else (or (eq? (car lat) a) 
                (member? a (cdr lat))
            )
      )
    )
  )
)

(define rember
  (lambda (a lat)
    (cond
      ((null? lat) (quote ()))
      ((eq? (car lat) a) (cdr lat))
      (else (cons (car lat) (rember a (cdr lat))))
    )
  )
)

(define firsts
  (lambda (l)
    (cond
      ((null? l) (quote ()))
      (else (cons (car (car l)) 
                  (firsts (cdr l))
            )
      )
    )
  )
)

(define insertR
  (lambda (adda pat lat)
    (cond
      ((null? lat) (quote ()))
      (else (cond
              ((eq? (car lat) pat) (cons pat (cons adda (cdr lat))))
              (else (cons (car lat) (insertR adda pat (cdr lat))))
            )
      )
    )
  )
)

(define insertL
  (lambda (adda pat lat)
    (cond
      ((null? lat) (quote ()))
      (else (cond
              ((eq? (car lat) pat) (cons adda (cons pat (cdr lat))))
              (else (cons (car lat) (insertL adda pat (cdr lat))))
            )
      )
    )
  )
)

(define add1
  (lambda (n)
    (+ n 1)))

(define sub1
  (lambda (n)
    (- n 1)))

(define Prependl
  (lambda (x y)
    (cond
      ((null? x) y)
      (else (cons (car x) (Prependl (cdr x) y)))
      )))

;--- neemt één paar p en maakt alle combos van paren met de lijst l ---
(define pplusl
  (lambda (p l)
    (cond
      ((null? l) '())
      (else (cons (Prependl p (car l)) (pplusl p (cdr l)) ))
      )))
(pplusl '(a b) '((a b) (b c) (l f)))

;--- neemt een lijst en doet het cartesisch product ---
(define carprod
  (lambda (l m)
    (cond
      ((null? l) '())
      (else (Prependl (pplusl (car l) m) (carprod (cdr l) m)))
      )))
(carprod '((a b) (c d)) '((e f) (g h)))