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

;--- infix to prefix with 2 atoms ----
(define inToPreAtoms
  (lambda (a o b)
    (cons o (cons a (cons b '())))
    ))
;--- (inToPreAtoms 4 '+ 6) ---

;--- infix to prefix with a an atom ---
(define inToPreA
  (lambda (a o b)
    (Prependl (cons o (cons a '())) (cons (prefix-notation b) '()))
    ))

;--- infix to prefix with b an atom ---
(define inToPreB
  (lambda (a o b)
    (cons o (cons (prefix-notation a) (cons b '())))
    ))

;--- infix to prefix with both lists ---
(define inToPreBoth
  (lambda (a o b)
    (cons o (cons (prefix-notation a) (cons (prefix-notation b) '())))
    ))

(define prefix-notation
  (lambda (l)
    (cond
      ((null? l) '())
      ((and (atom? (car l)) (atom? (car (cddr l))))
       (inToPreAtoms (car l) (car (cdr l)) (car (cddr l))))
      ((atom? (car l))
       (inToPreA (car l) (car (cdr l)) (car (cddr l))))
      ((atom? (car (cddr l)))
       (inToPreB (car l) (car (cdr l)) (car (cddr l))))
      (else (inToPreBoth (car l) (car (cdr l)) (car (cddr l))))
      )
    ))
;--- (prefix-notation '(1 + 5)) ---
(prefix-notation '(a + (b + c)))
(prefix-notation '((a + b) + c))
(prefix-notation '((a + b) + (c + d)))
(prefix-notation '(1 + (1 + (4 + 6))))
(prefix-notation '((1 + 3) + 4))
                 
