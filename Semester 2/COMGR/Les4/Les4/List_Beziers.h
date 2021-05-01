#ifndef __LIST_BEZIERS_H__
#define __LIST_BEZIERS_H__

#include <vector>
#include "Object_Bezier.h"

class List_Beziers  
{
public:
    Object_Bezier* GetBezier(int index); 
    int GetSize();
    void AddBezier(Object_Bezier *bezier);
    
    List_Beziers();
    virtual ~List_Beziers();
    
    std::vector<Object_Bezier*> m_Beziers;
};

#endif // __LIST_BEZIERS_H__
